<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/admins', name: 'admin_admins')]
class AdminController extends AbstractController
{
    #[Route('/', name: '', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/create', name: '_create', methods: ['GET', 'POST'])]
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user, true);

            return $this->redirectToRoute('admin_admins', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/new.html.twig', compact('user', 'form'));
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);
        // $data = $form->get('password')->getData();
        // $form->add('password', PasswordType::class, [
        //     'label' => 'Entrer le mot de passe actuel ou un nouveau'
        // ]);
        // dump($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userRepository->save($user, true);

            return $this->redirectToRoute('admin_admins', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/edit.html.twig', compact('user', 'form'));
    }

    #[Route('/supprimer/{id}', name: '_delete')]
    public function deleteAgent(EntityManagerInterface $em, User $admin): Response
    {
        $em->remove($admin);
        $em->flush();

        $this->addFlash('success', "Administrateur supprimé.");

        return $this->redirectToRoute('admin_admins');
    }
}
