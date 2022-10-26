<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pays', name: 'admin_country')]
class CountryController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(CountryRepository $countryRepo): Response
    {
        $countries = $countryRepo->findAll();

        return $this->render('country/index.html.twig', compact('countries'));
    }

    #[Route('/creation-pays', name: '_create')]
    public function createCountry(EntityManagerInterface $em, Request $request): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($country);
            $em->flush();

            $this->addFlash('success', "Type de mission ajouté.");

            return $this->redirectToRoute('admin_country');
        }

        return $this->renderForm('country/createCountry.html.twig', compact('form'));
    }

    #[Route('/suppression-pays/{id}', name: '_delete')]
    public function deleteCountry(EntityManagerInterface $em, Country $country): Response
    {
        $em->remove($country);
        $em->flush();

        $this->addFlash('success', "Type de mission supprimé.");

        return $this->redirectToRoute('admin_country');
    }

    #[Route('/modifier-pays/{id}', name: '_update')]
    public function updateCountry(EntityManagerInterface $em, Country $country, Request $request): Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($country);
            $em->flush();

            $this->addFlash('success', "Type de mission modifié.");

            return $this->redirectToRoute('admin_country');
        }

        return $this->renderForm('country/updateCountry.html.twig', compact('form'));
    }
}
