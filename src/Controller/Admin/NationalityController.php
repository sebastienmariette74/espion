<?php

namespace App\Controller\Admin;

use App\Entity\Nationality;
use App\Form\NationalityType;
use App\Repository\NationalityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/nationalites', name: 'admin_nationality')]
class NationalityController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(NationalityRepository $nationalityRepo): Response
    {
        $nationalities = $nationalityRepo->findAll();

        return $this->render('nationality/index.html.twig', compact('nationalities'));
    }

    #[Route('/creation-nationalite', name: '_create')]
    public function createNationality(EntityManagerInterface $em, Request $request): Response
    {
        $nationality = new Nationality();
        $form = $this->createForm(NationalityType::class, $nationality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($nationality);
            $em->flush();

            $this->addFlash('success', "Nationalité ajoutée.");

            return $this->redirectToRoute('admin_nationality');
        }

        return $this->renderForm('nationality/createNationality.html.twig', compact('form'));
    }

    #[Route('/suppression-nationalite/{id}', name: '_delete')]
    public function deleteNationality(EntityManagerInterface $em, Nationality $nationality): Response
    {
        $em->remove($nationality);
        $em->flush();

        $this->addFlash('success', "Nationalité supprimée.");

        return $this->redirectToRoute('admin_nationality');
    }

    #[Route('/modifier-nationalite/{id}', name: '_update')]
    public function updateNationality(EntityManagerInterface $em, Nationality $nationality, Request $request): Response
    {
        $form = $this->createForm(NationalityType::class, $nationality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($nationality);
            $em->flush();

            $this->addFlash('success', "Nationalité modifiée.");

            return $this->redirectToRoute('admin_nationality');
        }

        return $this->renderForm('nationality/updateNationality.html.twig', compact('form'));
    }
}
