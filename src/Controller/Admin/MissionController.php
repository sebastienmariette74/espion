<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use App\Repository\StatusMissionRepository;
use App\Repository\TypeMissionRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'admin_missions')]
class MissionController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(
        MissionRepository $missionRepo, 
        SpecialityRepository $specialityRepo, 
        TypeMissionRepository $typeMissionRepo,
        StatusMissionRepository $statusMissionRepo,
        Request $request, 
        PaginationService $pagination,
    ): Response
    {
        $missions = $missionRepo->findAll();
        $specialities = $specialityRepo->findBy([], ['name' => 'ASC']);
        $types = $typeMissionRepo->findBy([], ['name' => 'ASC']);
        $allStatus = $statusMissionRepo->findBy([], ['name' => 'ASC']);

        if (!$request->get('ajax')) {
            $limit = 9;
            $paginate = $pagination->pagination($request, $missionRepo, $limit, "getPaginated", null, null, "getTotal");
            $missions = $paginate['response'];
            $total = $paginate['total'];
            $page = $paginate['page'];

            return $this->render('mission/index.html.twig', compact('missions', 'total', 'limit', 'page', 'specialities', 'types', 'allStatus'));
        } else {            

            // tableau de tous les filtres
            $filters = [];
            $query = htmlentities($request->get("query"));
            $speciality = htmlentities($request->get("speciality"));
            $type = htmlentities($request->get("type"));
            $status = htmlentities($request->get("status"));
            $limit = (int)(htmlentities($request->get("limit")));

            $speciality != "" ? $filters['speciality'] = $speciality : "";
            $type != "" ? $filters['type'] = $type : "";
            $status != "" ? $filters['status'] = $status : "";
            
            // pagination
            $paginate = $pagination->pagination($request, $missionRepo, $limit, "getPaginated", $filters, $query, "getTotal");
            $missions = $paginate['response'];
            $total = $paginate['total'];
            $page = $paginate['page'];

            return $this->render('mission/_content.html.twig', compact('missions', 'total', 'limit', 'page', 'specialities', 'types', 'allStatus'));
        }

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

            $this->addFlash('success', "Mission ajout??e.");

            return $this->redirectToRoute('admin_missions');
        }

        return $this->renderForm('mission/createMission.html.twig', compact('form'));
    }

    #[Route('/suppression-mission/{id<\d+>}', name: '_delete')]
    public function deleteMission(EntityManagerInterface $em, Mission $mission): Response
    {
        $em->remove($mission);
        $em->flush();

        $this->addFlash('success', "Mission supprim??e.");

        return $this->redirectToRoute('admin_missions');
    }

    #[Route('/modifier-mission/{id<\d+>}', name: '_update')]
    public function updateMission(EntityManagerInterface $em, Mission $mission, Request $request): Response
    {
        if($request->get('ajax') == 1){
            $codename = $request->get('mission')->getCodeName();
            $mission->setCodeName($request->get('codeName'));
            $mission->setTitle($request->get('title'));
            $mission->setDescription($request->get('description'));
        }
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($mission);
            $em->flush();

            $this->addFlash('success', "Mission modifi??e.");
            return $this->redirectToRoute('admin_missions');
        }

        return $this->renderForm('mission/updateMission.html.twig', compact('form'));
    }
}
