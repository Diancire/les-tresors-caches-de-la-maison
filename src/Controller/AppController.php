<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('', name: 'app_app')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findPublishedLasted(2);
        return $this->render('app/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
