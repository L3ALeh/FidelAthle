<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeCoursesController extends AbstractController
{
    #[Route('/liste/course', name: 'app_liste_course')]
    public function index(): Response
    {
        return $this->render('liste_courses/index.html.twig', [
            'controller_name' => 'ListeCoursesController',
        ]);
    }
    #[Route('/courses/listes', name : 'couses_listes')]
    public function test()
    {
        return $this->render('liste_course/listeCourse.html.twig');
    }
}
