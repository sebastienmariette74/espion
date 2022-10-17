<?php

namespace App\Controller\Admin;

use App\Entity\TypeHidingPlace;
use App\Form\TypeHidingPlaceType;
use App\Repository\TypeHidingPlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/types-de-planque', name: 'admin_typeHidingPlace')]
class TypeHidingPlaceController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(TypeHidingPlaceRepository $typeHidingPlaceRepo): Response
    {
        $typesHidingPlace = $typeHidingPlaceRepo->findAll();

        return $this->render('typeHidingPlace/index.html.twig', compact('typesHidingPlace'));
    }

    #[Route('/creation-type-de-planque', name: '_create')]
    public function createTypeHidingPlace(EntityManagerInterface $em, Request $request): Response
    {
        $typeHidingPlace = new TypeHidingPlace();
        $form = $this->createForm(TypeHidingPlaceType::class, $typeHidingPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($typeHidingPlace);
            $em->flush();

            $this->addFlash('success', "Type de planque ajouté.");

            return $this->redirectToRoute('admin_typeHidingPlace');
        }

        return $this->renderForm('typeHidingPlace/createTypeHidingPlace.html.twig', compact('form'));
    }

    #[Route('/suppression-type-de-planque/{id}', name: '_delete')]
    public function deleteTypeHidingPlace(EntityManagerInterface $em, TypeHidingPlace $typeHidingPlace): Response
    {
        $em->remove($typeHidingPlace);
        $em->flush();

        $this->addFlash('success', "Type de planque supprimé.");

        return $this->redirectToRoute('admin_typeHidingPlace');
    }

    #[Route('/modifier-type-de-planque/{id}', name: '_update')]
    public function updateTypeHidingPlace(EntityManagerInterface $em, TypeHidingPlace $typeHidingPlace, Request $request): Response
    {
        $form = $this->createForm(TypeHidingPlaceType::class, $typeHidingPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($typeHidingPlace);
            $em->flush();

            $this->addFlash('success', "Type de planque modifié.");

            return $this->redirectToRoute('admin_typeHidingPlace');
        }

        return $this->renderForm('typeHidingPlace/updateTypeHidingPlace.html.twig', compact('form'));
    }
}
