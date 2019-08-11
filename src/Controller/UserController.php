<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditProfileType;

/**
 * Controller that manage user
 * 
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    public function profile()
    {
        return $this->render('user/profile.html.twig', [
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

    public function settings()
    {
        return $this->render('user/settings.html.twig', [
        ]);
    }
}
