<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller;

use App\Entity\User;
use App\Entity\Gender;
use App\Entity\LinkCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class FamilyTreeController extends AbstractController
{
    public function browse(UserRepository $userRepository, int $page = 1)
    {
        $list = $userRepository->getUsers($page);

        return $this->render('family_tree/browse.html.twig', [
            'users' => $list,
        ]);
    }

    public function show(Request $request, User $user, EntityManagerInterface $em): Response
    {
        if (null === $user) {
            return $this->createNotFoundException("Tree family can't be found. the username does not exists.");
        }

        return $this->render('family_tree/show.html.twig', [
            'user' => $user,
        ]);
    }

    public function listLinkNamesOfGender(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): JsonResponse
    {
        $gender = $em->getRepository(Gender::class)->findOneById($request->query->get('genderId'));
        $names = [];

        if ($gender) {
            $linkCategories = $em->getRepository(LinkCategory::class)->findByGender($gender);

            $linkCategories = array_filter($linkCategories, function(LinkCategory $link){
                return $link->getName() != $link->getInverse();
            });

            foreach ($linkCategories as $linkCategory) {
                $names['' . $linkCategory->getId() . ''] = $translator->trans($linkCategory->getName());
            }
        }

        return new JsonResponse($names);
    }
}
