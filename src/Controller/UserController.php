<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditProfileType;
use App\Form\EmailsType;
use App\Form\EditPasswordType;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Controller that manage user
 * 
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    public function profile(UserInterface $user = null)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'profile.edit_success');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function settings(Request $request, EntityManagerInterface $em, UserManagerInterface $userManager, UserInterface $user = null)
    {
        $formEmails = $this->createForm(EmailsType::class, $user);
        $formPassword = $this->createForm(EditPasswordType::class, $user);

        $formEmails->handleRequest($request);
        $formPassword->handleRequest($request);

        if($formEmails->isSubmitted() && $formEmails->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'setting.email_added');
            return $this->redirectToRoute('user_settings');
        }

        if($formPassword->isSubmitted() && $formPassword->isValid()) {
            $userManager->updateUser($user);

            $this->addFlash('success', 'setting.password_edited');
            return $this->redirectToRoute('user_settings');
        }

        return $this->render('user/settings.html.twig', [
            'form_emails' => $formEmails->createView(),
            'form_password' => $formPassword->createView(),
            'user' => $user
        ]);
    }
}
