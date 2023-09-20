<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LikeRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LikeController extends AbstractController
{
    #[Route('/like/article/{id}', name: 'app_like')]
    public function index($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, LikeRepository $likeRepository, Article $article): Response
    {

        if (!$this->getUser()){

            $this->addFlash('info', "Vous devez être connecté pour aimer cet article");

            // return  $this->redirectToRoute("app_home_page");
        }

        $user =$this->getUser();

        $articleId = $articleRepository->find($id);

        $verify = $likeRepository->findOneBy(['article'=>$articleId,"author"=>$user],[]);

        if ($verify === null){
            $like = new Like();
            $like->setAuthor($user);
            $like->setArticle($articleId);
            $entityManager->persist($like);
            $entityManager->flush();
            return $this->json([
                'message' => 'Le like a été ajouté.',
                'nbLike' => count($article->getLikes())
            ]);
    
        }else{

            $entityManager->remove($verify);
            $entityManager->flush();
            return $this->json([
                'message' => 'Le like a été supprimé.',
                'nbLike' => count($article->getLikes())
            ]);

        }
        // return $this->redirectToRoute("app_app");
    }
}
