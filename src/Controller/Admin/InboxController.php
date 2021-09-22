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
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to manage inbox.
 *
 * @Route("/admin/inbox")
 * @IsGranted("ROLE_ADMIN")
 */
class InboxController extends AbstractController
{
    /**
     * @Route("", name="admin_inbox")
     */
    public function index()
    {
        $list = $this->getDoctrine()->getRepository(Contact::class)->inbox(1);

        return $this->render('admin/inbox/index.html.twig', [
            'inbox' => $list,
            'count' => $this->getMessagesCount(),
        ]);
    }

    /**
     * @Route("/page/{page}", name="admin_inbox_paginated", requirements={"page"="\d+"})
     */
    public function paginate($page)
    {
        $list = $this->getDoctrine()->getRepository(Contact::class)->inbox($page);

        return $this->render('admin/inbox/index.html.twig', [
            'inbox' => $list,
        ]);
    }

    /**
     * @Route("/id", name="admin_inbox_message_show")
     *
     * Return One Contact message in json format
     *
     * @return JsonResponse
     */
    public function getMessage(Request $request)
    {
        $contact = $this->getDoctrine()->getRepository(Contact::class)->findOneById($request->query->get('id'));

        return new JsonResponse([
            'username' => $contact->getFullname(),
            'email' => $contact->getEmail(),
            'message' => $contact->getMessage(),
            'datetime' => $contact->getCreatedAt()->format('D d M, H:i'),
        ]);
    }

    /**
     * Return the number of message in the contact table.
     *
     * @return mixed: int|Response
     *                Return integer if we call it inside another mothod
     *                Else (that mean we called it inside a twig template) it return a Response
     */
    public function getMessagesCount()
    {
        /**
         * @var Symfony\Component\HttpFoundation\RequestStack
         */
        $requestStack = $this->container->get('request_stack');

        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();

        $count = $qb->select('count(c.id)')
            ->from('App:Contact', 'c')
            ->getQuery()
            ->getSingleScalarResult();

        if (null === $requestStack->getParentRequest()) {
            return $count;
        }

        return new Response($count);
    }
}
