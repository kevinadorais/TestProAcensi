<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Student;
use App\Entity\Department;
use App\Form\StudentType;
use Symfony\Component\HttpClient\HttpClient;


class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {

        # Ouverture de la database et récuperation des Students et departments.
        $em = $this->getDoctrine()->getManager(); 
        $students = $em->getRepository(Student::class)->findAll();
        $departments = $em->getRepository(Department::class)->findAll();

        return $this->render('default/home.html.twig', [
            'students' => $students,
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/home/{department}", name="homeStudents")
     */
    public function homeStudents($department)
    {
        # Ouverture de la database et récuperation des Students et departments.
        $em = $this->getDoctrine()->getManager(); 
        $students = $em->getRepository(Student::class)->findByDepartment($department);
        $departments = $em->getRepository(Department::class)->findAll();

        return $this->render('default/home.html.twig', [
            'students' => $students,
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/addStudent", name="addStudent")
     */
    public function addStudent(Request $request)
    {
        # Création du modèle de Student et du type de formulaire.
        $task = new Student();
        $form = $this->createForm(StudentType::class , $task);   
        $form->handleRequest($request);

        # Verification si le formulaire est valide.
        if ($form->isSubmitted() && $form->isValid()) {

            # Récuperation des données du formulaire.
            $task = $form->getData();

            # Ouverture de la database et enregistrement des données.
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            # Redirection.
            return $this->redirectToRoute('home');
        }

        return $this->render('default/addStudent.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("editStudent/{studentId}", name="editStudent")
     */
    public function editStudent($studentId, Request $request)
    {   
        # Ouverture de la database et récupération des données.
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Student::class)->find($studentId);
        $form = $this->createForm(StudentType::class , $task);            
        $form->handleRequest($request);

        # Verification si le formulaire est valide.
        if ($form->isSubmitted() && $form->isValid()) {

            # Récuperation des données du formulaire.
            $task = $form->getData(); 
            
            # Enregistrement des données.
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('default/editStudent.html.twig', [
            'form'=>$form->createView(),
            'student'=>$task,
        ]);
    }

    /**
     * @Route("removeStudent/{studentId}", name="removeStudent")
     */
    public function removeStudent($studentId)
    {          
        # Ouverture de la database et récupération des données.
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Student::class)->find($studentId);

        # Supression des données.
        $em->remove($task);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
