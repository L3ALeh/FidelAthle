<?php

namespace App\Controller;

use App\Repository\RecompenseRepository;
use App\Entity\ResultatCourse;
use App\Entity\User;
use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\ResultatCourseRepository;
use App\Repository\RecompenseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/api/lesCourses/participe/{id}', name: 'les_courses_participe')]
    public function coursesParticipees(User $leUser = null, UserRepository $userRep)
    {
        $lesCoursesParticipeesID = [];

        $lesCoursesParticipees = $leUser->getLesResultatsCourses();
        foreach($lesCoursesParticipees as $uneCourseParticipee){
            $lesCoursesParticipeesID[] = [
                'lesCoursesParticipees' => $uneCourseParticipee->getUneCourse()->getId()
            ];
        }

        return new JsonResponse($lesCoursesParticipeesID);
    }

    #[Route('/api/lesCourses', name: 'les_courses')]
    public function envoiCourse(CourseRepository $coursesRep)
    {
        $lesCourses = $coursesRep->findAll();

        $data = [];

        foreach($lesCourses as $uneCourse)
        {
            $data[] = [
                'id'        => $uneCourse->getId(),
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

    #[Route('/api/inscription/{id}/{course}', name: 'inscription_course')]
    public function inscriptionCourse(User $user, Course $course, EntityManagerInterface $manager = null) : Response
    {

        $resCourse = new ResultatCourse();
        
        $resCourse->setLeUser($user);

        $resCourse->setUneCourse($course);

        $manager->persist($resCourse);

        $manager->flush();

        return new JsonResponse('retour');
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