<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/missions', name: 'admin_missions')]
class MissionController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(MissionRepository $missionRepo, SpecialityRepository $specialityRepo): Response
    {
        $missions = $missionRepo->findAll();

        return $this->render('mission/index.html.twig', compact('missions'));
    }
    #[Route('/mission/{id}', name: '_details')]
    public function show(Mission $mission): Response
    {

        return $this->render('mission/show.html.twig', compact('mission'));
    }

    #[Route('/creation-mission', name: '_create')]
    public function createMission(EntityManagerInterface $em, Request $request): Response
    {
        $mission = new Mission();
        
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {            

            $em->persist($mission);
            $em->flush();

            $this->addFlash('success', "Mission ajoutée.");

            return $this->redirectToRoute('admin_missions');
        }

        return $this->renderForm('mission/createMission.html.twig', compact('form'));
    }

    #[Route('/suppression-mission/{id<\d+>}', name: '_delete')]
    public function deleteMission(EntityManagerInterface $em, Mission $mission): Response
    {
        $em->remove($mission);
        $em->flush();

        $this->addFlash('success', "Mission supprimée.");

        return $this->redirectToRoute('admin_missions');
    }

    #[Route('/modifier-mission/{id<\d+>}', name: '_update')]
    public function updateMission(EntityManagerInterface $em, Mission $mission, Request $request): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($mission);
            $em->flush();

            $this->addFlash('success', "Mission modifiée.");

            return $this->redirectToRoute('admin_missions');
        }

        return $this->renderForm('mission/updateMission.html.twig', compact('form'));
    }
}
