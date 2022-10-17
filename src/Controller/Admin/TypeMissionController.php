<?php

namespace App\Controller\Admin;

use App\Entity\TypeMission;
use App\Form\TypeMissionType;
use App\Repository\TypeMissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/types-de-mission', name: 'admin_typeMission')]
class TypeMissionController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(TypeMissionRepository $typeMissionRepo): Response
    {
        $typesMission = $typeMissionRepo->findAll();

        return $this->render('typeMission/index.html.twig', compact('typesMission'));
    }

    #[Route('/creation-type-de-mission', name: '_create')]
    public function createTypeMission(EntityManagerInterface $em, Request $request): Response
    {
        $typeMission = new TypeMission();
        $form = $this->createForm(TypeMissionType::class, $typeMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($typeMission);
            $em->flush();

            $this->addFlash('success', "Type de mission ajouté.");

            return $this->redirectToRoute('admin_typeMission');
        }

        return $this->renderForm('typeMission/createTypeMission.html.twig', compact('form'));
    }

    #[Route('/suppression-type-de-mission/{id}', name: '_delete')]
    public function deleteTypeMission(EntityManagerInterface $em, TypeMission $typeMission): Response
    {
        $em->remove($typeMission);
        $em->flush();

        $this->addFlash('success', "Type de mission supprimé.");

        return $this->redirectToRoute('admin_typeMission');
    }

    #[Route('/modifier-type-de-mission/{id}', name: '_update')]
    public function updateTypeMission(EntityManagerInterface $em, TypeMission $typeMission, Request $request): Response
    {
        $form = $this->createForm(TypeMissionType::class, $typeMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($typeMission);
            $em->flush();

            $this->addFlash('success', "Type de mission modifié.");

            return $this->redirectToRoute('admin_typeMission');
        }

        return $this->renderForm('typeMission/updateTypeMission.html.twig', compact('form'));
    }
}
