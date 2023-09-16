<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/article')]
class AdminArticleController extends AbstractController
{
    #[Route('/', name: 'app_admin_article_index')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $articles = $articleRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render('admin_article/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    
    #[Route('/new', name: 'app_admin_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($article);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $categories = $categoryRepository->findAll();
        return $this->render('admin_article/new.html.twig', [
            'article' => $article,
            'form' => $form,
            'categories' => $categories
        ]);
    }
    
    #[Route('/{id}', name: 'app_admin_article_show', methods: ['GET'])]
    public function show(Article $article, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin_article/show.html.twig', [
            'article' => $article,
            'categories' => $categories
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_admin_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "Les modifications ont bien été enregistré !");
            return $this->redirectToRoute('app_admin_article_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $categories = $categoryRepository->findAll();
        return $this->render('admin_article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
            'categories' => $categories
        ]);
    }
    #[Route('/{id}', name: 'app_admin_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository, EntityManagerInterface $manager, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $manager->remove($article);
            $manager->flush();
            $this->addFlash('success', 'L\'article a bien été supprimé !');
        }
        
        $categories = $categoryRepository->findAll();
        return $this->redirectToRoute('app_admin_article_index', [
            'categories' => $categories
        ], Response::HTTP_SEE_OTHER);
    }
}
