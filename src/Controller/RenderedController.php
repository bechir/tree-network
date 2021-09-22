<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller;

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
