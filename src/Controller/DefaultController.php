<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
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

    public function contact(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new \Swift_Message($this->getParameter('website.name').' - [Contact]'))
                ->setFrom($contact->getEmail())
                ->setTo($this->getParameter('website.email'))
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
                        array('user' => $contact)
                    ),
                    'text/plain'
                );
            $mailer->send($message);

            $this->addFlash('success', 'contact.message_sent');
            return $this->redirectToRoute('homepage');
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
