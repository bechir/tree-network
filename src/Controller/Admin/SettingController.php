<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("admin/settings")
 */
class SettingController extends AbstractController
{
    /**
     * @Route("/", name="admin_settings")
     */
    public function settings(Request $request): Response
    {
        return $this->render('admin/settings/index.html.twig');
    }

    /**
     * @Route("/banner-ad", name="admin_settings_banner_ad")
     */
    public function bannerAd(Request $request): Response
    {
        return $this->render('admin/settings/banner-ad.html.twig', [
            'active' => 'banner-ad'
        ]);
    }
    
    /**
     * @Route("/emails", name="admin_settings_emails")
     */
    public function emails(Request $request): Response
    {
        return $this->render('admin/settings/emails.html.twig', [
            'active' => 'emails'
        ]);
    }
    
    /**
     * @Route("/admin-users", name="admin_settings_admin_users")
     */
    public function adminUsers(Request $request, EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->getAdminUsers();
        return $this->render('admin/settings/admin/users.html.twig', [
            'active' => 'admin-users',
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin-users/search", name="admin_settings_search_user")
     */
    public function searchUser(Request $request, EntityManagerInterface $em): Response
    {
        $terms = $request->query->get('terms');
        $users = $em->getRepository(User::class)->findBySearchTermsAdmin($terms);

        return $this->render('admin/settings/admin/search-result.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin-users/add", name="admin_settings_add_admin_user")
     */
    public function addAdminUser(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $userId = $request->query->get('userId');

        $user = $em->getRepository(User::class)->findOneById($userId);

        if($user) {
            $user->addRole('ROLE_ADMIN');
            $em->flush();

            return new JsonResponse([
                'code' => 200,
                'message' => "L'utilisateur a été ajouté comme administrateur."
            ]);
        }
        else {
            return new JsonResponse([
                'code' => 404,
                'message' => "L'utilisateur est introuvable."
            ]);
        }
    }

    /**
     * @Route("/admin-users/edit-role", name="admin_settings_edit_user_role")
     */
    public function editUserRole(Request $request, EntityManagerInterface $em): Response
    {
        $userId = $request->query->get('userId');
        $role = intval($request->query->get('role'));

        $user = $em->getRepository(User::class)->findOneById($userId);

        if($user) {
            if($role) {
                $nbSuperUsers = $this->getNbSperAdminUsers();
                $success = true;

                switch($role) {
                    case 1:
                        if($nbSuperUsers <= 1 && $user->hasRole('ROLE_SUPER_ADMIN')) {
                            $success = false;
                        } else {
                            $user->removeRole('ROLE_SUPER_ADMIN')
                                ->removeRole('ROLE_MODERATOR')
                                ->addRole('ROLE_ADMIN');
                        }
                        break;
                    case 2:
                        if($nbSuperUsers <= 1 && $user->hasRole('ROLE_SUPER_ADMIN')) {
                            $success = false;
                        } else {
                            $user->removeRole('ROLE_SUPER_ADMIN')
                                ->addRole('ROLE_MODERATOR');
                        }
                        break;
                    case 3:
                        $user->addRole('ROLE_SUPER_ADMIN');
                        break;
                    default: break;
                }

                if($success) {
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success', 'Le rôle a été modifié.');
                } else {
                    $this->addFlash('danger', "Il doit y avoir au moins un adminstrateur avec un accès global.");
                }

                return $this->redirectToRoute('admin_settings_admin_users');
            }

            return $this->render('admin/settings/admin/edit-role-form.html.twig', [
                'user' => $user
            ]);
        } else {
            $this->addFlash('danger', 'Utilisateur introuvable.');
            return $this->redirectToRoute('admin_settings_admin_users');
        }
    }

    /**
     * @Route("/admin-users/{user}/remove-from-admins", name="admin_settings_remove_from_admin")
     */
    public function removeFromAdmin(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $nbSuperUsers = $this->getNbSperAdminUsers();

        if($nbSuperUsers <= 1 && $user->hasRole('ROLE_SUPER_ADMIN')) {
            $this->addFlash('danger', "Il doit y avoir au moins un adminstrateur avec un accès global.");
        } else {
            $user->removeRole('ROLE_ADMIN')
                ->removeRole('ROLE_MODERATOR')
                ->removeRole('ROLE_SUPER_ADMIN');
        
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "L'utilisateur a été retiré des adminstrateurs.");
        }
        return $this->redirectToRoute('admin_settings_admin_users');
    }

    public function getNbSperAdminUsers()
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();

        return $qb->select('count(u.id)')
            ->from('App:User', 'u')
            ->where('u.roles like :roles')
            ->setParameter('roles', '%ROLE_SUPER_ADMIN%')
            ->getQuery()
            ->getSingleScalarResult();
    }
}