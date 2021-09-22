<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\EventSubscriber;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

class ProfileEditCompletedSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onFosUserProfileEditCompleted(Event $event)
    {
        $user = $event->getUser();

        if (filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $email = $user->getEmail();
            $isSubscribed = $this->em->getRepository(Newsletter::class)->findOneByEmail($email);

            if (!$isSubscribed) {
                $newsletter = (new Newsletter())
                    ->setEmail($user->getEmail())
                    ->setRegistrationUrl('user_settings');

                $this->em->persist($newsletter);
                $this->em->flush();
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'fos_user.profile.edit.completed' => 'onFosUserProfileEditCompleted',
        ];
    }
}
