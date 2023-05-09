<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeCoursesController extends AbstractController
{
    #[Route('/liste/course', name: 'app_liste_course')]
    public function index(): Response
    {
        return $this->render('liste_course/index.html.twig', [
            'controller_name' => 'ListeCoursesController',
        ]);
    }
    #[Route('/courses/listes', name : 'couses_listes')]
    public function listeCourses()
    {
        return $this->render('liste_course/listeCourse.html.twig', [
            'historique' => '0'
        ]);
    }
    #[Route('/courses/historique', name : 'couses_historique')]
    public function historiqueCourses()
    {
        return $this->render('liste_course/listeCourse.html.twig', [
            'historique' => '1'
        ]);
    }
    #[Route('/courses/organisees', name : 'couses_organisee')]
    public function courseOrganisee()
    {
        return $this->render('liste_course/courseOrganisees.html.twig');
    }
}
