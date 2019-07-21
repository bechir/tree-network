<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Controller that manage user
 * 
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    public function profile()
    {
        return $this->render('user/profile.html.twig', [
        ]);
    }

    public function edit()
    {
        return $this->render('user/edit.html.twig', [
        ]);
    }

    public function settings()
    {
        return $this->render('user/settings.html.twig', [
        ]);
    }
}
