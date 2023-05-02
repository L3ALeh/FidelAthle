<?php

namespace App\Controller;

use App\Entity\ResultatCourse;
use App\Entity\User;
use App\Entity\Course;
use App\Repository\CourseRepository;
use App\Repository\ResultatCourseRepository;
use App\Repository\UserRepository;
use DateTime;
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

    #[Route('/api/coursesOrganisees/{idUser}', name: 'les_courses_organisees')]
    #[Route('/api/coursesOrganisees/{idUser}/course/{idCourse}', name: 'la_course_organisee')]
    public function coursesOrganisees(CourseRepository $courses, User $idUser, Course $idCourse = null)
    {
        if($idCourse != null)
        {
            return $this->render('liste_course/coursesOrganisateur.html.twig', [
                'idCourse' => $idCourse->getId()
            ]);
        }
        if($idUser->isEstOrganisateur())
        {
            $lesCourses = $courses->findBy(array('unOrganisateur' => $idUser));
            $data = [];
            foreach($lesCourses as $uneCourse)
            {
                $data[] = [
                    'id'        => $uneCourse->getId(),
                    'nomCourse' => $uneCourse->getNomCourse(),
                    'dateCourse' => $uneCourse->getDate()->format('Y-m-d')
                ];
            }
            return new JsonResponse($data);
        }
        else{
            return new JsonResponse(null);
        }
    }

    #[Route('/api/tempsCoureur/{idResCourse}/temps/{temps}', name: 'changement_temps_coureur')]
    public function enregistrementTempsCoureur(ResultatCourseRepository $courseRep, ResultatCourse $idResCourse, string $temps, EntityManagerInterface $manager = null)
    {
        $leResultatCoureur = $courseRep->findOneBy(array('id' => $idResCourse));

        $leResultatCoureur = $leResultatCoureur->setTemps($temps);

        $manager->persist($leResultatCoureur);

        $manager->flush();

        return new JsonResponse(true);
    }

    #[Route('/api/lesCoureurs/{id}', name: 'les_coureurs')]
    public function coureursResultats(ResultatCourseRepository $coursesRep, Course $laCourse)
    {
        $lesResultats = $coursesRep->findBy(array('uneCourse' => $laCourse));
        $data = [];
        foreach($lesResultats as $unResultat)
        {
            $data[] = [
                'id' => $unResultat->getId(),
                'coureur' => $unResultat->getLeUser()->getNom() . ' ' . $unResultat->getLeUser()->getPrenom(),
                'classement' => $unResultat->getPosition(),
                'temps' => $unResultat->getTemps(),
                'moyenne' => $unResultat->getVitesseMoyenne()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/lesCourses/{value}/{id}', name: 'les_courses')]
    public function envoiCourse(CourseRepository $coursesRep, string $value, User $user = null)
    {
        $date = new DateTime();
        
        if($value == '1')
        {
            $lesCourses = $coursesRep->findByDateAndUser($date, $user);
        }
        else{
            $lesCourses = $coursesRep->findByDate($date);
        }

        $data = [];

        foreach($lesCourses as $uneCourse)
        {
            if($value == '1')
            {
                $data[] = [
                'id'        => $uneCourse->getId(),
                'nomCourse' => $uneCourse->getNomCourse(),
                'dateCourse' => $uneCourse->getDate()->format('Y-m-d'),
                'prixCourse' => $uneCourse->getPrix(),
                'distanceCourse' => $uneCourse->getDistance(),
                'typeCourse' => $uneCourse->getUnTypeCourse()->getLabel(),
                'niveauCourse' => $uneCourse->getUnNiveauCourse()->getLabel(),
                'position' => $uneCourse->getLesResultatsCoursesByID($user)->getPosition(),
                'moyenne'  => $uneCourse->getLesResultatsCoursesByID($user)->getVitesseMoyenne(),
                'temps'    => $uneCourse->getLesResultatsCoursesByID($user)->getTemps()
                ];
            }
            else{
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
        }
        return new JsonResponse($data);
    }

    #[Route('/api/inscription/{id}/{course}', name: 'inscription_course')]
    public function inscriptionCourse(User $user, Course $course, EntityManagerInterface $manager = null) : Response
    {

        $resCourse = new ResultatCourse();
        
        $resCourse->setLeUser($user);

        $resCourse->setTemps('00:00:00');

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
        
        foreach($lesRecompenses as $uneRec)
        {
            $data[]=[
                'label'=> $uneRec->getLabel(),
                'valeur'=> $uneRec->getValeur(),
                'valeurPoints'=> $uneRec->getValeurPoints()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/voirRecompenses', name : 'rec')]
    public function recompoints()
    {
        return $this->render('gestion_recompenses/recompenses.html.twig');
    }


    #[Route('/api/recuppoints/{id}', name: 'recup_points')]
    public function recuppoints(User $user)
    {
        $lesPoints = $user->getNombreDePoints();

        return new JsonResponse($lesPoints);
    }

    #[Route('/home', name: 'HomeMenu')]
    public function Menu()
    {
        return $this ->render('home_menu/homeMenu.html.twig');
    }

}