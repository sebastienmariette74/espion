<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusMissionRepository;
use App\Repository\TypeMissionRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/agents', name: 'admin_agents')]
class AgentController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(
        AgentRepository $agentRepo, 
        SpecialityRepository $specialityRepo,
        TypeMissionRepository $typeMissionRepo,
        StatusMissionRepository $statusMissionRepo,
        Request $request,
        PaginationService $pagination
    ): Response
    {
        $agents = $agentRepo->findAll();

        if (!$request->get('ajax')) {
            $offset = 9;
            $paginate = $pagination->pagination($request, $agentRepo, $offset, "getPaginated", null, null, "getTotal");
            $agents = $paginate['response'];
            $total = $paginate['total'];
            $limit = $paginate['limit'];
            $page = $paginate['page'];

            return $this->render('agent/index.html.twig', compact('agents', 'total', 'limit', 'page', 'offset'));
        } else {            

            // tableau de tous les filtres
            $filters = [];
            $query = htmlentities($request->get("query"));
            $offset = (int)(htmlentities($request->get("offset")));

            // pagination
            $paginate = $pagination->pagination($request, $agentRepo, $offset, "getPaginated", $filters, $query, "getTotal");
            $agents = $paginate['response'];
            $total = $paginate['total'];
            $limit = $paginate['limit'];
            $page = $paginate['page'];

            return $this->render('agent/_content.html.twig', compact('agents', 'total', 'limit', 'page', 'offset'));
        }
    }

    #[Route('/agent/{code}', name: '_show')]
    public function show(Agent $agent): Response
    {              

        return $this->render('agent/show.html.twig', compact('agent'));
    }

    #[Route('/agent/details/{id}', name: '_details')]
    public function details(Agent $agent): Response
    {              

        return $this->render('agent/details.html.twig', compact('agent'));
    }

    #[Route('/creation-agent', name: '_create')]
    public function createAgent(EntityManagerInterface $em, Request $request): Response
    {
        $agent = new Agent();
        
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
