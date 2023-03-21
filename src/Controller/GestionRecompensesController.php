<?php

namespace App\Controller;

use App\Entity\Recompense;
use App\Form\GestionRecompensesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionRecompensesController extends AbstractController
{
   #[Route('/gestionrecompenses', name: 'app_gestion_recompenses')]
   
   public function index(): Response
    {
        return $this->render('gestion_recompenses/index.html.twig', [
            'controller_name' => 'GestionRecompensesController',
        ]);
    }
    #[Route('/voirRecompenses', name: 'voir_recompense')]
    #[Route('/{id}/ajout', name: 'ajout_recompense')]
    public function GestionRecompenses(Recompense $uneRecompense = null,
    Request $request, 
    EntityManagerInterface $manager)
    {
        
        if(!$uneRecompense)
        {$uneRecompense = new Recompense();}
        
 
        $form = $this->createForm(GestionRecompensesType::class,$uneRecompense);
 
        $form->handleRequest($request);
 
        return $this->render('gestion_recompenses/recompenses.html.twig', [
            'form' => $form->createView(),
        ]);
    }

   
}