<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('', name: 'app_app')]
    public function index(ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $articles = $articleRepository->findPublishedLasted(2);
        $categories = $categoryRepository->findAll();
        return $this->render('app/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    #[Route('/histoire', name: 'app_history')]
    public function history(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('app/history.html.twig', [
            'categories' => $categories
        ]);
    }
    #[Route('/mention-legal', name: 'app_legal_notice')]
    public function PrivacyPolicy(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('app/legal_notice.html.twig', [
            'categories' => $categories
        ]);
    }
    #[Route('/politique-confidentialite', name: 'app_privacy_policy')]
    public function legalNotice(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('app/privacy_policy.html.twig', [
            'categories' => $categories
        ]);
    }
}
