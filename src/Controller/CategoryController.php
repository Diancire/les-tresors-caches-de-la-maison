<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\SearchType;
use App\Model\SearchData;
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
    public function index(Category $category,ArticleRepository $articleRepository, Request $request, CategoryRepository $categoryRepository): Response
    {

        $searchData = new SearchData();

        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $articles = $articleRepository->findBySearch($searchData);
            $categories = $categoryRepository->findAll();
            return $this->render('article/index.html.twig', [
                'articles' => $articles,
                'form' => $form,             
                'categories' => $categories, 
            ]);
        }
        
        $articles = $articleRepository->findPublished($request->query->getInt('page', 1), $category);
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'category' => $category,
            'articles' => $articles,
            'categories' => $categories,
            'form' => $form         
        ]);
    }
}
