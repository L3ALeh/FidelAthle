<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActionControlController extends AbstractController
{
    #[Route('/action/control', name: 'retour')]
    public function index(): Response
    {
        return $this->render('action_control/index.html.twig', [
            'controller_name' => 'ActionControlController',
        ]);
    }
}
