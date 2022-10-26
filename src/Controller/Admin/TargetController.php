<?php

namespace App\Controller\Admin;

use App\Entity\Target;
use App\Entity\Speciality;
use App\Form\TargetType;
use App\Repository\TargetRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/targets', name: 'admin_targets')]
class TargetController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(TargetRepository $targetRepo, SpecialityRepository $specialityRepo): Response
    {
        $targets = $targetRepo->findAll();

        return $this->render('target/index.html.twig', compact('targets'));
    }

    #[Route('/creation-target', name: '_create')]
    public function createTarget(EntityManagerInterface $em, Request $request): Response
    {
        $target = new Target();
        
        $form = $this->createForm(TargetType::class, $target);
        // dd($form->getData());
        // $form->remove('dateOfBirth');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($target);
            $em->flush();

            $this->addFlash('success', "Target ajouté.");

            return $this->redirectToRoute('admin_targets');
        }

        return $this->renderForm('target/createTarget.html.twig', compact('form'));
    }

    #[Route('/suppression-target/{id<\d+>}', name: '_delete')]
    public function deleteTarget(EntityManagerInterface $em, Target $target): Response
    {
        $em->remove($target);
        $em->flush();

        $this->addFlash('success', "Target supprimé.");

        return $this->redirectToRoute('admin_targets');
    }

    #[Route('/modifier-target/{id<\d+>}', name: '_update')]
    public function updateTarget(EntityManagerInterface $em, Target $target, Request $request): Response
    {
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($target);
            $em->flush();

            $this->addFlash('success', "Target modifié.");

            return $this->redirectToRoute('admin_targets');
        }

        return $this->renderForm('target/updateTarget.html.twig', compact('form'));
    }
}
