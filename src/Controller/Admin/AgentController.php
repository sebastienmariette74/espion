<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Entity\Speciality;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/agents', name: 'admin_agents')]
class AgentController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(AgentRepository $agentRepo, SpecialityRepository $specialityRepo): Response
    {
        $agents = $agentRepo->findAll();
        $specialities = $specialityRepo->findAll();
        // dd($agents[0]->getNationality());

        return $this->render('agent/index.html.twig', compact('agents', 'specialities'));
    }

    #[Route('/creation-agent', name: '_create')]
    public function createAgent(EntityManagerInterface $em, Request $request): Response
    {
        $agent = new Agent();
        
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($agent);
            $em->persist($agent);
            $em->flush();

            $this->addFlash('success', "Agent ajouté.");

            return $this->redirectToRoute('admin_agents');
        }

        return $this->renderForm('agent/createAgent.html.twig', compact('form'));
    }

    #[Route('/suppression-agent/{id<\d+>}', name: '_delete')]
    public function deleteAgent(EntityManagerInterface $em, Agent $agent): Response
    {
        $em->remove($agent);
        $em->flush();

        $this->addFlash('success', "Agent supprimé.");

        return $this->redirectToRoute('admin_agents');
    }

    #[Route('/modifier-agent/{id<\d+>}', name: '_update')]
    public function updateAgent(EntityManagerInterface $em, Agent $agent, Request $request): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($agent);
            $em->flush();

            $this->addFlash('success', "Agent modifié.");

            return $this->redirectToRoute('admin_agents');
        }

        return $this->renderForm('agent/updateAgent.html.twig', compact('form'));
    }
}
