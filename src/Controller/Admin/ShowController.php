<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Entity\HidingPlace;
use App\Entity\Target;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{
    #[Route('/hidingPlace/{code}', name: 'hidingPlace_show')]
    public function showHidingPlace(HidingPlace $hidingPlace): Response
    {               

        return $this->render('hidingPlace/show.html.twig', compact('hidingPlace'));
    }

    #[Route('/agent/{code}', name: 'agent_show')]
    public function showAgent(Agent $agent): Response
    {              

        return $this->render('agent/show.html.twig', compact('agent'));
    }

    #[Route('/target/{code}', name: 'target_show')]
    public function showTarget(Target $target): Response
    {
        return $this->render('target/show.html.twig', compact('target'));
    }
}
