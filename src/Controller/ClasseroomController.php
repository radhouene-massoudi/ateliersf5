<?php

namespace App\Controller;

use App\Entity\Classeroom;
use App\Form\ClasseroomType;
use App\Repository\ClasseroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ClasseroomController extends AbstractController
{
    #[Route('/classeroom', name: 'liste')]
    public function index(ClasseroomRepository $classeroomRepository): Response
    {
        $result=$classeroomRepository->findAll();
        return $this->render('classeroom/index.html.twig', [
            'classerooms' => $result,
        ]);
    }

    #[Route('/addclassroom', name: 'addclasseroom')]
    public function addClassroom(Request $request, ManagerRegistry $doctrine): Response
    {
        $classeroom = new Classeroom();
        $form = $this->createForm(ClasseroomType::class, $classeroom);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $em=$doctrine->getManager();
            $em->persist($classeroom);
            $em->flush();
             return $this->redirectToRoute('liste');
        }

        return $this->render('classeroom/new.html.twig', [
            'classeroom' => $classeroom,
            'form' => $form->createView(),
        ]);
    }

    #[Route('detailclassroom/{id}', name: 'show')]
    public function detailClassroom(ClasseroomRepository $repo,$id): Response
    {
        $result=$repo->find($id);
        return $this->render('classeroom/show.html.twig', [
            'classeroom' => $result,
        ]);
    }

    #[Route('updateclassroom/{id}', name: 'update')]
    public function updateClassroom(Request $request, ManagerRegistry $doctrine,Classeroom $classeroom, ClasseroomRepository $classeroomRepository): Response
    {
        $form = $this->createForm(ClasseroomType::class, $classeroom);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em=$doctrine->getManager();
            //$em->persist($classeroom);
            $em->flush();
             return $this->redirectToRoute('liste');
        }

        return $this->render('classeroom/edit.html.twig', [
            'classeroom' => $classeroom,
            'form' => $form->createView(),
        ]);
    }

    #[Route('removeclassroom/{id}', name: 'remove')]
    public function deleteClassroom(ManagerRegistry $doctrine, ClasseroomRepository $repo,$id): Response
    {
        $em=$doctrine->getManager();
        $result=$repo->find($id);
        $em->remove($result);
        $em->flush(); 

        return $this->redirectToRoute('liste');
    }
}
