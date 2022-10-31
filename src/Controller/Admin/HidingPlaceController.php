<?php

namespace App\Controller\Admin;

use App\Entity\HidingPlace;
use App\Entity\Speciality;
use App\Form\HidingPlaceType;
use App\Repository\HidingPlaceRepository;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/hidingPlaces', name: 'admin_hidingPlaces')]
class HidingPlaceController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(HidingPlaceRepository $hidingPlaceRepo, SpecialityRepository $specialityRepo, MissionRepository $missionRepo): Response
    {
        $hidingPlaces = $hidingPlaceRepo->findAll();
        $missions = $missionRepo->findAll();
        // dd($hidingPlaces);

        return $this->render('hidingPlace/index.html.twig', compact('hidingPlaces', 'missions'));
    }

    #[Route('/hidingPlace/{code}', name: '_show')]
    public function show(HidingPlace $hidingPlace, HidingPlaceRepository $hidingPlaceRepo, SpecialityRepository $specialityRepo, MissionRepository $missionRepo): Response
    {
               

        return $this->render('hidingPlace/show.html.twig', compact('hidingPlace'));
    }

    #[Route('/creation-hidingPlace', name: '_create')]
    public function createHidingPlace(EntityManagerInterface $em, Request $request): Response
    {
        $hidingPlace = new HidingPlace();
        
        $form = $this->createForm(HidingPlaceType::class, $hidingPlace);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $hidingPlace->setCountry($form->get('country')->getData());
            // dd($hidingPlace->getCountry());
            
            $em->persist($hidingPlace);
            $em->flush();

            $this->addFlash('success', "Planque ajoutée.");

            // return $this->redirectToRoute('admin');
            return $this->redirectToRoute('admin_hidingPlaces');
        }

        return $this->renderForm('hidingPlace/createHidingPlace.html.twig', compact('form'));
    }

    #[Route('/suppression-hidingPlace/{id<\d+>}', name: '_delete')]
    public function deleteHidingPlace(EntityManagerInterface $em, HidingPlace $hidingPlace): Response
    {
        $em->remove($hidingPlace);
        $em->flush();

        $this->addFlash('success', "Planque supprimée.");

        return $this->redirectToRoute('admin_hidingPlaces');
    }

    #[Route('/modifier-hidingPlace/{id<\d+>}', name: '_update')]
    public function updateHidingPlace(EntityManagerInterface $em, HidingPlace $hidingPlace, Request $request): Response
    {
        $form = $this->createForm(HidingPlaceType::class, $hidingPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($hidingPlace);
            $em->flush();

            $this->addFlash('success', "Planque modifiée.");

            return $this->redirectToRoute('admin_hidingPlaces');
        }

        return $this->renderForm('hidingPlace/updateHidingPlace.html.twig', compact('form'));
    }
}
