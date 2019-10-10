<?php

namespace App\EventSubscriber;

use App\Entity\Newsletter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class UserRegistrationSubscriber implements EventSubscriberInterface
{
    public function onFosUserRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $user = $event->getUser();

        if(filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $email = $user->getEmail();
            $isSubscribed = $this->em->getRepository(Newsletter::class)->findOneByEmail($email);

            if(!$isSubscribed) {
                $newsletter = (new Newsletter())
                    ->setEmail($user->getEmail())
                    ->setRegistrationUrl('user_settings')
                    ->setLocale($user->getLocale());
                
                $this->em->persist($newsletter);
                $this->em->flush();
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'fos_user.registration.completed' => 'onFosUserRegistrationCompleted',
        ];
    }
}
