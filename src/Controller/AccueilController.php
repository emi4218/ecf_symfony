<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(ArticleRepository $repo): Response
    {
        $listeArticles = $repo->findAll();

        return $this->render('accueil/index.html.twig', [
            'listeArticles' => $listeArticles,
        ]);
    }

    #[Route('/lire/{id}', name: 'lire_article')]
    public function lireArticle(Article $article): Response
    {
        return $this->render('accueil/lire.html.twig', [
            'article' => $article,
        ]);
    }
}
