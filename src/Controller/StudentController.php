<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StudentController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function home(StudentRepository $studentRepository): Response
    {
        $students=$studentRepository->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/addstudent', name: 'addstudent')]
    public function addStudent(Request $request, ManagerRegistry $mg): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $em=$mg->getManager();
$em->persist($student);
$em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('student/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('detaailst/{id}', name: 'detailst')]
    public function detailStudent($id,StudentRepository $repo): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $repo->find($id),
        ]);
    }

    #[Route('updatest/{id}', name: 'updatest', )]
    public function updateStudent(Request $request, Student $student,ManagerRegistry $mg ): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $em=$mg->getManager();
            $em->persist($student);
            $em->flush();
                        return $this->redirectToRoute('index');
             }

        return $this->render('student/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('remove/{id}', name: 'deletest')]
    public function removeStudent( $id, StudentRepository $repo,ManagerRegistry $mg): Response
    {
        $student=$repo->find($id);
           
        $em=$mg->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
