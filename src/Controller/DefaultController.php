<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    public function about(): Response
    {
        return $this->render('default/about.html.twig', [
            // 'stats' => $this->getStats()
        ]);
    }

    public function privacy(): Response
    {
        return $this->render('default/privacy.html.twig');
    }

    public function contact(Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer, ContainerInterface $container): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = [$container->getParameter('website.email') => $container->getParameter('website.name')];
            $message = (new \Swift_Message($contact->getSubject()))
                ->setFrom($address)
                ->setTo($address)
                ->setSubject($contact->getSubject())
                ->setContentType('text/html')
                ->setBody(
                    $this->renderView(
                          'emails/contact.html.twig',
                          ['user' => $contact]
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView(
                        'emails/contact.txt.twig',
                        ['user' => $contact]
                    ),
                    'text/plain'
                );
            $mailer->send($message);

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'contact.message_sent');

            return $this->redirectToRoute('index');
        }

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function helpFAQ(): Response
    {
        return $this->render('default/helpFAQ.html.twig');
    }

    public function termsCondtions(): Response
    {
        return $this->render('default/termsCondtions.html.twig');
    }
}
