<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CreationCourseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CreationCourseController extends AbstractController
{
    #[Route('/creation/course', name: 'app_creation_course')]
    public function index(): Response
    {
        return $this->render('creation_course/index.html.twig', [
            'controller_name' => 'CreationCourseController',
        ]);
    }

    #[Route('/creation/courses', name:'CreationCourse')]
    public function gestionCourse(Course $laCourse = null,
     Request $request,
      EntityManagerInterface $manager)
      {
        if (!$laCourse)
        { $laCourse = new Course();}
        
        $userId = $this->getUser();

        $form = $this->createForm(CreationCourseType::class, $laCourse);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $laCourse->setUnOrganisateur($userId);

            $manager->persist($laCourse);

            $manager->flush();

            return $this->render('home_menu/homeMenu.html.twig');
        }

        return $this->render('creation_course/creationCourse.html.twig', ['form'=>$form, 'manager'=>$manager]);
      }
}
