<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FamilyTreeController extends AbstractController
{
    public function browse(UserRepository $userRepository)
    {
        $list = $userRepository->findAll();

        return $this->render('family_tree/browse.html.twig', [
            'users' => $list,
        ]);
    }

    public function show(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if(null === $user) {
            return $this->createNotFoundException("Tree family can't be found. the username does not exists.");
        }

        return $this->render('family_tree/show.html.twig', [
            'user' => $user,
        ]);
    }
}
