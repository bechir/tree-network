<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller;

use App\Entity\Link;
use App\Entity\LinkCategory;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditProfileType;
use App\Form\EmailsType;
use App\Form\EditPasswordType;
use App\Form\GalleryType;
use App\Form\LinkType;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;

/**
 * Controller that manage user.
 */
class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     */
    public function profile(EntityManagerInterface $em, UserInterface $user = null)
    {
        $recents = $em->getRepository(Link::class)->findRecentsByOwner($user);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'recents' => $recents,
        ]);
    }

    public function show(User $user, EntityManagerInterface $em)
    {
        $recents = $em->getRepository(Link::class)->findRecentsByOwner($user);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'recents' => $recents,
        ]);
    }

    public function galleryShow(User $user)
    {
        return $this->render('user/gallery.html.twig', [
            'user' => $user,
        ]);
    }

    public function search(Request $request, EntityManagerInterface $em): Response
    {
        $terms = $request->query->get('terms');
        $users = [];
        if($terms) {
            $users = $em->getRepository(User::class)->findBySearchTerms($terms);
        }
        return $this->render('common/search-result.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function gallery(UserInterface $user = null)
    {
        return $this->render('user/gallery.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function galleryEdit(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        $form = $this->createForm(GalleryType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'edit_success');

            return $this->redirectToRoute('user_gallery');
        }

        return $this->render('user/gallery-edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher, UserInterface $user = null)
    {
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $event = new UserEvent($user, $request);
            $eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, $event);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        if ($request->isMethod('POST')) {
            $em->delete($user);
            $em->flush();

            $this->addFlash('success', 'user.delete_success');
        }

        return $this->render('user/delete.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function settings(Request $request, EntityManagerInterface $em, UserManagerInterface $userManager, UserInterface $user = null)
    {
        $formEmails = $this->createForm(EmailsType::class, $user);
        $formPassword = $this->createForm(EditPasswordType::class, $user);

        $formEmails->handleRequest($request);
        $formPassword->handleRequest($request);

        if ($formEmails->isSubmitted() && $formEmails->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'setting.email_added');

            return $this->redirectToRoute('user_settings');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $userManager->updateUser($user);

            $this->addFlash('success', 'setting.password_edited');

            return $this->redirectToRoute('user_settings');
        }

        return $this->render('user/settings.html.twig', [
            'form_emails' => $formEmails->createView(),
            'form_password' => $formPassword->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function treeShow(Request $request, EntityManagerInterface $em, UserInterface $user = null): Response
    {
        if (null === $user) {
            return $this->createNotFoundException("Tree family can't be found. the username does not exists.");
        }

        $link = new Link();
        $form = $this->createForm(LinkType::class, $link, [
            'user' => $user,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $link->setOwner($user);

            $user->addLink($link);
            $linkCategory = $em->getRepository(LinkCategory::class)
                ->findOneBy(
                    ['name' => $link->getLinkCategory()->getInverse()]
            );

            $inversedLink = (new Link())
                ->setLinkCategory($linkCategory)
                ->setOwner($link->getInverse())
                ->setInverse($user)
            ;

            $link->getInverse()->addLink($inversedLink);

            $em->persist($inversedLink);
            $em->persist($link);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le lien a été ajouté.');

            return $this->redirectToRoute('user_tree_show');
        }

        return $this->render('user/tree-show.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
