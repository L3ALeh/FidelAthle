<?php

namespace App\Controller;

use App\Repository\RecompenseRepository;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    #[Route('/api/lesCourses', name: 'les_courses')]
    public function envoiCourse(CourseRepository $coursesRep)
    {
        $lesCourses = $coursesRep->findAll();

        $data = [];

        foreach($lesCourses as $uneCourse)
        {
            $data[] = [
                'nomCourse' => $uneCourse->getNomCourse(),
                'dateCourse' => $uneCourse->getDate()->format('Y-m-d'),
                'prixCourse' => $uneCourse->getPrix(),
                'distanceCourse' => $uneCourse->getDistance(),
                'typeCourse' => $uneCourse->getUnTypeCourse()->getLabel(),
                'niveauCourse' => $uneCourse->getUnNiveauCourse()->getLabel()
            ];
        }
        return new JsonResponse($data);
    }


    #[Route('/courses/listes', name : 'couses_listes')]
    public function test()
    {
        return $this->render('liste_course/listeCourse.html.twig');
    }


    #[Route('/api/lesRecompenses', name: 'recompensesaffichees')]

    public function GestionRecompenses(RecompenseRepository $uneRecompense)
    {
        $lesRecompenses = $uneRecompense->findAll();
        $data = [];
        
        foreach($lesRecompenses as $uneRecompense)
        {
            $data[]=[
                'label'=> $uneRecompense->getLabel(),
                'valeur'=> $uneRecompense->getValeur(),
                'valeurPoints'=> $uneRecompense->getValeurPoints()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/voirRecompenses', name : 'rec')]
    public function RECOMP()
    {
        return $this->render('gestion_recompenses/recompenses.html.twig');
    }

    #[Route('/api/lesPoints/{id}', name: 'pointsnnn')]

    public function GestionPoints(PointRepository $unPoint, User $leUser = null)
    {
        $lesPoints = $unPoint->find($leUser);
        $data = [];
        
        foreach($lesPoints as $unPoint)
        {
            $data[]=[
                'nombre'=> $unPoint->getNombre(),
            ];
        }
        return new JsonResponse($data);
    }
    #[Route('/voirRecompenses', name : 'rec')]
    public function recompoint()
    {
        return $this->render('gestion_recompenses/recompenses.html.twig');
    }

}
