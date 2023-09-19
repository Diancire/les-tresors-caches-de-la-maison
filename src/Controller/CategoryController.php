<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories')]
class CategoryController extends AbstractController
{
    #[Route('/{slug}', name: 'app_category')]
    public function index(Category $category,ArticleRepository $articlesRepository, Request $request, CategoryRepository $categoryRepository): Response
    {
        $articles = $articlesRepository->findPublished($request->query->getInt('page', 1), $category);
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
}
