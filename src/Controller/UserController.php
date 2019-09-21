<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\LinkCategory;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EditProfileType;
use App\Form\EmailsType;
use App\Form\EditPasswordType;
use App\Form\LinkType;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Controller that manage user
 */
class UserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     */
    public function profile(UserInterface $user = null)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    public function show(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, EntityManagerInterface $em, UserInterface $user = null)
    {
        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'profile.edit_success');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     */
    public function settings(Request $request, EntityManagerInterface $em, UserManagerInterface $userManager, UserInterface $user = null)
    {
        $formEmails = $this->createForm(EmailsType::class, $user);
        $formPassword = $this->createForm(EditPasswordType::class, $user);

        $formEmails->handleRequest($request);
        $formPassword->handleRequest($request);

        if($formEmails->isSubmitted() && $formEmails->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'setting.email_added');
            return $this->redirectToRoute('user_settings');
        }

        if($formPassword->isSubmitted() && $formPassword->isValid()) {
            $userManager->updateUser($user);

            $this->addFlash('success', 'setting.password_edited');
            return $this->redirectToRoute('user_settings');
        }

        return $this->render('user/settings.html.twig', [
            'form_emails' => $formEmails->createView(),
            'form_password' => $formPassword->createView(),
            'user' => $user
        ]);
    }

    public function treeShow(Request $request, UserInterface $user, EntityManagerInterface $em): Response
    {
        if(null === $user) {
            return $this->createNotFoundException("Tree family can't be found. the username does not exists.");
        }

        $link = new Link();
        $form = $this->createForm(LinkType::class, $link, [
            'user' => $user
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $link->setOwner($user);
            $user->addLink($link);
            $linkCategory = $em->getRepository(LinkCategory::class)
                ->findOneBy(
                    ['name' => $link->getLinkCategory()->getInverse()]
            );
            
            $inversedLink = (new Link())
                ->setLinkCategory($linkCategory)
                ->setOwner($link->getInverse())
                ->setInverse($user)
            ;
            
            $link->getInverse()->addLink($inversedLink);

            $em->persist($inversedLink);
            $em->persist($link);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le lien a été ajouté.');
            return $this->redirectToRoute('user_tree_show');
        }
        
        return $this->render('user/tree-show.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Returns a JSON string with the neighborhoods of the City with the providen id.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function linkCategoriesList(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $categoriesRepository = $em->getRepository(ProductSubCategory::class);

        // Search the neighborhoods that belongs to the city with the given id as GET parameter "cityid"
        $categories = $categoriesRepository->createQueryBuilder("q")
            ->leftJoin("q.parentCategory", "p")
              ->addSelect("p")
            ->where("p.slug = :slug")
            ->setParameter("slug", $request->query->get("category"))
            ->getQuery()
            ->getResult();

        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($categories as $category){
            $responseArray[] = array(
                "slug" => $category->getSlug(),
                "name" => $category->getName()
            );
        }

        // Return array with structure of the neighborhoods of the providen city id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }
}
