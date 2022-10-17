<?php

namespace App\Controller\Admin;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/specialites', name: 'admin_speciality')]
class SpecialityController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(SpecialityRepository $specialityRepo): Response
    {
        $specialities = $specialityRepo->findAll();

        return $this->render('speciality/index.html.twig', compact('specialities'));
    }

    #[Route('/creation-nationalite', name: '_create')]
    public function createSpeciality(EntityManagerInterface $em, Request $request): Response
    {
        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($speciality);
            $em->flush();

            $this->addFlash('success', "Nationalité ajoutée.");

            return $this->redirectToRoute('admin_speciality');
        }

        return $this->renderForm('speciality/createSpeciality.html.twig', compact('form'));
    }

    #[Route('/suppression-nationalite/{id}', name: '_delete')]
    public function deleteSpeciality(EntityManagerInterface $em, Speciality $speciality): Response
    {
        $em->remove($speciality);
        $em->flush();

        $this->addFlash('success', "Nationalité supprimée.");

        return $this->redirectToRoute('admin_speciality');
    }

    #[Route('/modifier-nationalite/{id}', name: '_update')]
    public function updateSpeciality(EntityManagerInterface $em, Speciality $speciality, Request $request): Response
    {
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($speciality);
            $em->flush();

            $this->addFlash('success', "Nationalité modifiée.");

            return $this->redirectToRoute('admin_speciality');
        }

        return $this->renderForm('speciality/updateSpeciality.html.twig', compact('form'));
    }
}
