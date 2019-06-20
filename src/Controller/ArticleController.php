<?php

namespace App\Controller;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article_show")
     */

    public function show(Article $article) :Response
    {
        return $this
            ->render(
                'blog/article.html.twig', 
                [
                'article'=>$article
                ]
            );
    }

    /**
     *@Route("/articles", name="article_list")
     */

    public function list()
    {
        $articles=$this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        return $this
            ->render(
                'blog/list.html.twig', 
                [
                    'articles' => $articles
                ]
            );
    }
}