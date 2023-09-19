<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Form\AdminType;
use App\Form\NewUserType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function dashboard(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/dashboard.html.twig', [
            'categories' => $categories
        ]);
    }
    #[Route('/utilisateurs', name: 'app_admin_index_user', methods: ['GET'])]
    public function index(UserRepository $userRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'categories' => $categories
        ]);
    }

    #[Route('/utilisateurs/new', name: 'app_admin_new_user', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, CategoryRepository $categoryRepository): Response
    {
        $user = new User();
        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setCreateAt(new DateTime);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'categories' => $categories
        ]);
    }
    
    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(User $user, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/show.html.twig', [
            'user' => $user,
            'categories' => $categories
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "Les modifications ont bien été enregistré !");
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    #[Route('/{id}/change-password', name: 'app_admin_change_password', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, User $user,UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', "Le mot de passe a été modifié avec succès !");
            return $this->redirectToRoute('app_admin_show', ['id' => $user->getId()]);
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/change_password.html.twig', [
            'user' => $user,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    #[Route('/utilisateurs/{id}/edit', name: 'app_admin_edit_user', methods: ['GET', 'POST'])]
    public function editUser(Request $request, User $user, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "Les modifications ont bien été enregistré !");
            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }
        $categories = $categoryRepository->findAll();
        return $this->render('admin/edit_users.html.twig', [
            'user' => $user,
            'form' => $form,
            'categories' => $categories
        ]);
    }

    #[Route('/{id}', name: 'app_admin_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $this->addFlash('success', "Votre compte a été supprimé avec succès.");
        $categories = $categoryRepository->findAll();
        return $this->redirectToRoute('app_app', [
            'categories' => $categories
        ], Response::HTTP_SEE_OTHER);
    }
    
    #[Route("/delete/{id}", name:'admin_crud_delete_user')]
    public function deleteUser(User $user = null, EntityManagerInterface $manager, CategoryRepository $categoryRepository)
    {
        if ($user) {
            $manager->remove($user);
            $manager->flush();
            $this->addFlash('success', 'Le membre a bien été supprimé !');
        }
        $categories = $categoryRepository->findAll();
        return $this->redirectToRoute('app_admin_index_user', [
            'categories' => $categories
        ]);
    }
}
