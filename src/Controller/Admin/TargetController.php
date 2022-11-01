<?php

namespace App\Controller\Admin;

use App\Entity\Target;
use App\Form\TargetType;
use App\Repository\TargetRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusMissionRepository;
use App\Repository\TypeMissionRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/targets', name: 'admin_targets')]
class TargetController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(
        TargetRepository $targetRepo, 
        TypeMissionRepository $typeMissionRepo,
        StatusMissionRepository $statusMissionRepo,
        Request $request,
        PaginationService $pagination
    ): Response
    {
        $targets = $targetRepo->findAll();

        if (!$request->get('ajax')) {
            $offset = 9;
            $paginate = $pagination->pagination($request, $targetRepo, $offset, "getPaginated", null, null, "getTotal");
            $targets = $paginate['response'];
            $total = $paginate['total'];
            $limit = $paginate['limit'];
            $page = $paginate['page'];

            return $this->render('target/index.html.twig', compact('targets', 'total', 'limit', 'page', 'offset'));
        } else {            

            // tableau de tous les filtres
            $filters = [];
            $query = htmlentities($request->get("query"));
            $offset = (int)(htmlentities($request->get("offset")));
            
            // pagination
            $paginate = $pagination->pagination($request, $targetRepo, $offset, "getPaginated", $filters, $query, "getTotal");
            $targets = $paginate['response'];
            $total = $paginate['total'];
            $limit = $paginate['limit'];
            $page = $paginate['page'];

            return $this->render('target/_content.html.twig', compact('targets', 'total', 'limit', 'page', 'offset'));
        }
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
