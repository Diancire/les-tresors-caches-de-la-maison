<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {

        $data = $articleRepository->findPublished();
        $articles = $paginatorInterface->paginate(
            $data,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    #[Route('/blog/{slug}', name: 'app_blog_show')]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }
}
