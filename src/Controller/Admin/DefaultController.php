<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to manage default admin pages.
 *
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 *
 * @author Bechir Ba <bechiirr71@gmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="admin_index")
     * @Route("", name="admin_index")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->adminGetRecents();

        return $this->render('admin/pages/index.html.twig', [
            'data' => $this->getStats(),
            'users' => $users,
        ]);
    }

    /**
     * @Route("/basic-usage", name="admin_basic_usage")
     */
    public function basicUsage(Request $request): Response
    {
        return $this->render('admin/pages/basicUsage.html.twig');
    }

    /**
     * @Route("/security", name="admin_security")
     */
    public function security(Request $request): Response
    {
        return $this->render('admin/pages/security.html.twig');
    }

    /**
     * @Route("/troubleshooting", name="admin_troubleshooting")
     */
    public function troubleshooting(Request $request): Response
    {
        return $this->render('admin/pages/troubleshooting.html.twig');
    }

    /**
     * @Route("/stats", name="admin_stats")
     */
    public function stats(Request $request): Response
    {
        return $this->render('admin/pages/stats.html.twig');
    }

    /**
     * @Route("/notifications", name="admin_notifications")
     */
    public function notifications(Request $request): Response
    {
        return $this->render('admin/pages/notifications.html.twig');
    }

    /**
     * @Route("/settings", name="admin_settings")
     */
    public function settings(Request $request): Response
    {
        return $this->render('admin/pages/settings.html.twig');
    }

    /**
     * @Route("/demo/{name}", name="admin_page_demo")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function pageDemo($name): Response
    {
        return $this->render("admin/demo/$name.html.twig");
    }

    public function getStats()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();

        $users = $qb->select('count(u.id)')->from('App:User', 'u')
            ->getQuery()->getSingleScalarResult();

        return [
            'users' => $users,
            'online' => 13,
        ];
    }
}
