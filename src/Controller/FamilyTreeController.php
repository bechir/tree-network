<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;

class FamilyTreeController extends AbstractController
{
    public function browse(UserRepository $userRepository)
    {
        $list = $userRepository->findAll();

        return $this->render('family_tree/browse.html.twig', [
            'users' => $list,
        ]);
    }

    public function show(User $user)
    {
        if(null === $user)
            return $this->createNotFoundException("Tree family can't be found. the username does not exists.");

            return $this->render('family_tree/show.html.twig', [
            'user' => $user,
        ]);
    }
}
