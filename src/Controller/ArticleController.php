<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\SearchType;
use App\Form\CommentType;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepository, Request $request, CategoryRepository $categoryRepository): Response
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
        
        $articles = $articleRepository->findPublished($request->query->getInt('page', 1));
        $categories = $categoryRepository->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories, 
            'form' => $form,
        ]);
    }
    #[Route('/blog/{slug}', name: 'app_blog_show', methods: ['GET', 'POST'])]
    public function show(Article $article, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        if($this->getUser()) {
            $comment->setAuthor($this->getUser());
        }
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', "Votre commentaire a été ajouté avec succès !");

            return $this->redirectToRoute('app_blog_show', ['slug' => $article->getSlug()]);
        }

        $categories = $categoryRepository->findAll();
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'categories' => $categories, 
            'form' => $form
        ]);
    }
}
