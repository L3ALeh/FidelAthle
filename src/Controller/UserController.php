<?php

namespace App\Controller;

use App\Form\UserInfosType;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Class_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/checkUser', name : 'gestionUtilisateurs')]
    #[Route('/user/{id}/checkUser', name : 'gestionUtilisateurss')]
    public function gestionUtilisateur(User $leUser = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$leUser)
        {$leUser = new User();}

        $form = $this->createForm(UserInfosType::class, $leUser);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            
            $manager->persist($leUser);
            
            $manager->flush();
 
            return $this->redirectToRoute('retour');
        }

        return $this->render('user/vueUser.html.twig', ['form'=>$form, 'editmode' => $leUser->getId() !== null]);
    }
}
