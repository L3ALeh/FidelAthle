<?php

namespace App\Controller;

use App\Entity\ResultatCourse;
use App\Entity\User;
use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\ResultatCourseRepository;
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
}
