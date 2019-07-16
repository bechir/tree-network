<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TreeFamilyController extends AbstractController
{
    public function browse()
    {
        return $this->render('tree-family/browse.html.twig', [
            'controller_name' => 'TreeFamilyController',
        ]);
    }
}
