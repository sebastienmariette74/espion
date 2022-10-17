<?php

namespace App\Controller\Admin;

use App\Entity\StatusMission;
use App\Form\StatusMissionType;
use App\Repository\StatusMissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/statuts', name: 'admin_statusMission')]
class StatusMissionController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(StatusMissionRepository $statusMissionRepo): Response
    {
        $statusMission = $statusMissionRepo->findAll();

        return $this->render('statusMission/index.html.twig', compact('statusMission'));
    }

    #[Route('/creation-statut', name: '_create')]
    public function createStatusMission(EntityManagerInterface $em, Request $request): Response
    {
        $statusMission = new StatusMission();
        $form = $this->createForm(StatusMissionType::class, $statusMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($statusMission);
            $em->flush();

            $this->addFlash('success', "Statut ajouté.");

            return $this->redirectToRoute('admin_statusMission');
        }

        return $this->renderForm('statusMission/createStatusMission.html.twig', compact('form'));
    }

    #[Route('/suppression-statut/{id}', name: '_delete')]
    public function deleteStatusMission(EntityManagerInterface $em, StatusMission $statusMission): Response
    {
        $em->remove($statusMission);
        $em->flush();

        $this->addFlash('success', "Statut supprimé.");

        return $this->redirectToRoute('admin_statusMission');
    }

    #[Route('/modifier-statut/{id}', name: '_update')]
    public function updateStatusMission(EntityManagerInterface $em, StatusMission $statusMission, Request $request): Response
    {
        $form = $this->createForm(StatusMissionType::class, $statusMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($statusMission);
            $em->flush();

            $this->addFlash('success', "Statut modifié.");

            return $this->redirectToRoute('admin_statusMission');
        }

        return $this->renderForm('statusMission/updateStatusMission.html.twig', compact('form'));
    }
}
