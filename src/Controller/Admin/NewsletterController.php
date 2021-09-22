<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Newsletter;
use App\Form\Admin\NewsletterMessageType;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to manage Newsletters.
 *
 * @Route("/admin/newsletter")
 * @IsGranted("ROLE_ADMIN")
 *
 * @author Bechir Ba <bechiirr71@gmail.com>
 */
class NewsletterController extends AbstractController
{
    /**
     * @Route("/index", name="admin_newsletter_index")
     */
    public function index(Request $request): Response
    {
        $users = $this->getDoctrine()->getRepository(Newsletter::class)->findAll();

        return $this->render('admin/newsletter/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/compose", name="admin_newsletter_compose")
     */
    public function compose(Request $request, ContainerInterface $container, \Swift_Mailer $mailer, NewsletterRepository $userRepo): Response
    {
        $newsletterMessage = new Contact();
        $form = $this->createForm(NewsletterMessageType::class, $newsletterMessage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipients = [];
            $users = $userRepo->findAll();
            $em = $this->getDoctrine()->getManager();

            foreach ($users as $user) {
                if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
                    $recipients[] = $user->getEmail();

                    $user->setToken(md5(uniqid($user->getEmail())));
                    $em->persist($user);
                }
            }
            $em->flush();

            $message = (new \Swift_Message($newsletterMessage->getSubject()))
                ->setFrom([$container->getParameter('website.email') => $container->getParameter('website.name')])
                ->setTo($recipients)
                ->setBcc($recipients)
                ->setSubject($newsletterMessage->getSubject())
                ->setBody(
                    $this->renderView('admin/newsletter/_message.html.twig', ['message' => $newsletterMessage]),
                    'text/html',
                    'utf8'
                )
                ->addPart(
                    $this->renderView('admin/newsletter/_message.txt.twig', ['message' => $newsletterMessage]),
                    'text/plain',
                    'utf8'
                )
            ;

            $mailer->send($message);

            $this->addFlash('success', 'Le message a été envoyé avec succès.');
        }

        return $this->render('admin/newsletter/compose.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
