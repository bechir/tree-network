<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Controller that manage security part of the backend.
 *
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/user/{user}", name="admin_user_show")
     */
    public function show(Request $request, User $user): Response
    {
        if (!$user) {
            return $this->render('admin/pages/404.html.twig');
        }

        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new/user", name="admin_user_create")
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);

            $em->flush();

            $this->addFlash('success', "L'utilisateur a été créé avec succès.");

            return $this->redirectToRoute('admin_user_show', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{user}/edit", name="admin_user_edit")
     */
    public function edit(Request $request, User $user, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);

            $em->flush();

            $this->addFlash('success', "L'utilisateur a été modifié avec succès.");

            return $this->redirectToRoute('admin_user_show', [
                'user' => $user->getId(),
            ]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Profile page.
     *
     * @Route("/profile", name="admin_profile")
     */
    public function profile(Request $request): Response
    {
        return $this->show($request, $this->getUser());
    }

    /**
     * @Route("/users", name="admin_users")
     */
    public function users(Request $request): Response
    {
        $list = $this->getDoctrine()->getRepository(User::class)->getUsers(1);

        return $this->render('admin/user/list.html.twig', [
          'users' => $list,
        ]);
    }

    /**
     *  List users pagination.
     *
     * @Route("/users/page/{page}", name="admin_users_paginated", requirements={"page"="\d+"})
     */
    public function usersPaginate(Request $request, $page): Response
    {
        $list = $this->getDoctrine()->getRepository(User::class)->getUsers($page);

        return $this->render('admin/user/list.html.twig', [
          'users' => $list,
        ]);
    }

    /**
     * @Route("/security/user/disable", name="admin_security_user_disable", methods={"POST"})
     */
    public function disableUser(Request $request): JsonResponse
    {
        return $this->setUserEnabled($request, false);
    }

    /**
     * @Route("/security/user/enable", name="admin_security_user_enable", methods={"POST"})
     */
    public function enableUser(Request $request): JsonResponse
    {
        return $this->setUserEnabled($request, true);
    }

    /**
     * @Route("/security/user/delete/{id}", name="admin_security_user_delete", methods={"POST"})
     */
    public function deleteUser(User $user)
    {
        if (!$user) {
            $this->addFlash('success', "L'utilisateur est introuvable.");
        } else {
            if ($user->hasRole('ROLE_ADMIN')) {
                $this->addFlash('success', 'Impossible de supprimer cet administrateur.');
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->remove($user);
                $em->flush();
                $this->addFlash('success', "L'utilisateur a été supprimé.");
            }
        }

        return $this->redirectToRoute('admin_index');
    }

    private function setUserEnabled(Request $request, $enabled): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->find(User::class, $request->request->get('id'));

        if ($user) {
            $user->setEnabled($enabled);

            $em->flush();
        }

        return new JsonResponse(true);
    }
}
