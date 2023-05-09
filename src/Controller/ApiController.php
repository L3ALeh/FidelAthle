<?php

namespace App\Controller;

use App\Entity\ResultatCourse;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Recompense;
use App\Entity\Obtention;
use App\Repository\CourseRepository;
use App\Repository\ObtentionRepository;
use App\Repository\RecompenseRepository;
use App\Repository\ResultatCourseRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
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

    #[Route('/api/user/{id}', name: 'get_user')]
    public function getLeUser(UserRepository $userRepository, User $id)
    {
        $leUser = $userRepository->findOneBy(array('id' => $id));

        $data = [
            'id' => $leUser->getId(),
            'estOrganisateur' =>$leUser->isEstOrganisateur()
        ];

        return new JsonResponse($data);
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

    #[Route('/api/ajoutPoint/{array}/course/{idCourse}')]
    public function gestionPoints(string $array, Course $idCourse, ResultatCourseRepository $resultatCourseRepository, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $array = explode(',', $array);
        $lesResultats = $resultatCourseRepository->findResCourseOrder($idCourse);
        $compteur = 0;
        foreach($lesResultats as $unResultat) {
            $unUser = $userRepository->findOneBy(array('id' => $unResultat->getLeUser()->getId()));
            $unUser->setNombreDePoints($unUser->getNombreDePoints() + $array[$compteur]);
            $compteur += 1;
            $manager->persist($unUser);
            $manager->flush();
        }
        return new JsonResponse(true);
    }

    #[Route('/api/post/coureurs/{array}/course/{laCourse}/{choix}', name: 'post_coureurs')]
    public function postResultatCourse(string $array, Course $laCourse, string $choix, ResultatCourseRepository $coursesRep, EntityManagerInterface $manager)
    {
        $array = explode(',', $array);
        $lesResultats = $coursesRep->findResCourseOrder($laCourse);
        $compteur = 0;
        foreach($lesResultats as $unResultat){
            if($choix == 'position'){
                $unResultat->setPosition(strVal($array[$compteur]));
            }
            else{
                $unResultat->setClassementDefinitif(strVal($array[$compteur]));
            }
            $compteur += 1;
            $manager->persist($unResultat);
            $manager->flush();
        }
        return new JsonResponse(true);
    }

    #[Route('/api/lesCoureurs/{id}', name: 'les_coureurs')]
    public function coureursResultats(ResultatCourseRepository $coursesRep, Course $laCourse)
    {
        $lesResultats = $coursesRep->findResCourseOrder($laCourse);
        $data = [];
        foreach($lesResultats as $unResultat)
        {
            $data[] = [
                'id' => $unResultat->getId(),
                'coureur' => $unResultat->getLeUser()->getNom() . ' ' . $unResultat->getLeUser()->getPrenom(),
                'classement' => $unResultat->getPosition(),
                'temps' => $unResultat->getTemps(),
                'moyenne' => $unResultat->getVitesseMoyenne(),
                'definitif' => $unResultat->isClassementDefinitif()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/get/course/{id}', name: 'get_la_course')]
    public function getCourse(Course $id, CourseRepository $courseRepository)
    {
        $laCourse = $courseRepository->findOneBy(array('id' => $id));

        $data = [
            'id' => $laCourse->getId(),
            'niveau' => $laCourse->getUnNiveauCourse(),
            'date' => $laCourse->getDate()
        ];

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

        $resCourse->setClassementDefinitif(false);

        $manager->persist($resCourse);

        $manager->flush();

        return new JsonResponse('retour');
    }

    #[Route('/api/ajoutRecompense/{idRecompense}/{idUser}', name: 'post_recompense')]
    public function AjoutRecompense(Recompense $idRecompense, User $idUser, ObtentionRepository $obtentionRepository, EntityManagerInterface $manager)
    {
        $uneObtention = $obtentionRepository->findOneBy(array('unUser' => $idUser, 'uneRecompense' => $idRecompense));
        if($uneObtention != null) {
            $uneObtention->setQuantite($uneObtention->getQuantite() + 1);
            $manager->persist($uneObtention);
        }
        else {
            $uneNouvelleObtention = new Obtention();
            $uneNouvelleObtention->setQuantite(1);
            $uneNouvelleObtention->setUneRecompense($idRecompense);
            $uneNouvelleObtention->setUnUser($idUser);
            $manager->persist($uneNouvelleObtention);
        }
        $idUser->setNombreDePoints($idUser->getNombreDePoints() - $idRecompense->getValeurPoints());
        $manager->persist($idUser);
        $manager->flush();
        return new JsonResponse(true);
    }

    #[Route('/api/lesRecompenses', name: 'recompensesaffichees')]
    public function GestionRecompenses(RecompenseRepository $uneRecompense)
    {

        $lesRecompenses = $uneRecompense->findAll();
        $data = [];
        
        foreach($lesRecompenses as $uneRec)
        {
            $data[]=[
                'id' => $uneRec->getId(),
                'image' => $uneRec->getImage(),
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

    #[Route('/api/changementValeur/{intitule}/{texte}/{idUser}', name: 'profil_modif')]
    public function changementValeur(string $intitule, string $texte, User $idUser, EntityManagerInterface $manager)
    {
        switch ($intitule) {
            case "pseudo" :
                $idUser->setPseudo($texte);
                break;
            case "email" :
                $idUser->setEmail($texte);
                break;
            case "adresse" :
                $idUser->setAdresse($texte);
                break;
            default :
                break;
        }

        $manager->persist($idUser);

        $manager->flush();

        return new JsonResponse(true);
    }

    #[Route('/api/certificatMedical/{fichier}/{idUser}', name: 'certificatMedical')]
    public function ajoutCertificat(string $fichier, User $idUser, EntityManagerInterface $manager)
    {
        $idUser->setCertificatMedical($fichier);
        $manager->persist($idUser);
        $manager->flush();
        return new JsonResponse(true);
    }


    #[Route('/api/userProfil/{idUser}', name: 'le_profil_user')]
    public function userProfil(UserRepository $userRep, User $idUser)
    {
        $leUser = $userRep->findOneBy(array('id' => $idUser->getId()));
        $data = [
            'nom'=>$leUser->getNom(),
            'prenom'=>$leUser->getPrenom(),
            'pseudo'=>$leUser->getPseudo(),
            'adresse'=>$leUser->getAdresse(),
            'email'=>$leUser->getEmail()
        ];
        return new JsonResponse($data);
    }
}