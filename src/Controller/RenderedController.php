<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;

class RenderedController extends AbstractController
{
    public function recents(UserRepository $userRepository)
    {
        $list = $userRepository->findRecents();

        return $this->render('rendered/recents.html.twig', [
            'users' => $list,
        ]);
    }
}
