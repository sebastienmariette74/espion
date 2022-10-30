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

    #[Route('/target/{code}', name: '_show')]
    public function show(Target $target): Response
    {
        return $this->render('target/show.html.twig', compact('target'));
    }

    #[Route('/target/details/{id}', name: '_details')]
    public function details(Target $target): Response
    {
        return $this->render('target/details.html.twig', compact('target'));
    }

    #[Route('/creation-target', name: '_create')]
    public function createTarget(EntityManagerInterface $em, Request $request): Response
    {
        
        // if($request->get('ajax')){
        //     $target = new Target();
        //     dump('ajax=1');
        //     $form = $this->createForm(TargetType::class, $target);
        // // dd($form->getData());
        // // $form->remove('dateOfBirth');
        // $form->handleRequest($request);

        // // dd($target);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // dump($target);
        //     dd('request2');

        //     $em->persist($target);
        //     $em->flush();

        //     $this->addFlash('success', "Target ajouté.");

        //     // return $this->redirectToRoute('admin_targets');
        // }

        // return $this->renderForm('target/_content.html.twig', compact('form'));
        // }

        $target = new Target();
        $form = $this->createForm(TargetType::class, $target);
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
