<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}