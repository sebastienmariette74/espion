<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\SpecialityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/contacts', name: 'admin_contacts')]
class ContactController extends AbstractController
{
    #[Route('/', name: '')]
    public function index(ContactRepository $contactRepo, SpecialityRepository $specialityRepo): Response
    {
        $contacts = $contactRepo->findAll();

        return $this->render('contact/index.html.twig', compact('contacts'));
    }

    #[Route('/contact/details/{id}', name: '_details')]
    public function details(Contact $contact): Response
    {

        return $this->render('contact/details.html.twig', compact('contact'));
    }

    #[Route('/creation-contact', name: '_create')]
    public function createContact(EntityManagerInterface $em, Request $request): Response
    {
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);
        // dd($form->getData());
        // $form->remove('dateOfBirth');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', "Contact ajouté.");

            return $this->redirectToRoute('admin_contacts');
        }

        return $this->renderForm('contact/createContact.html.twig', compact('form'));
    }

    #[Route('/suppression-contact/{id<\d+>}', name: '_delete')]
    public function deleteContact(EntityManagerInterface $em, Contact $contact): Response
    {
        $em->remove($contact);
        $em->flush();

        $this->addFlash('success', "Contact supprimé.");

        return $this->redirectToRoute('admin_contacts');
    }

    #[Route('/modifier-contact/{id<\d+>}', name: '_update')]
    public function updateContact(EntityManagerInterface $em, Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', "Contact modifié.");

            return $this->redirectToRoute('admin_contacts');
        }

        return $this->renderForm('contact/updateContact.html.twig', compact('form'));
    }
}
