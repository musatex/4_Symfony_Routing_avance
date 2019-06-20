<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{id}", name="category_show")
     */

    public function show(Category $category) : Response
    {
        return $this
            ->render(
                'blog/category.html.twig', 
                [
                    'category'=>$category
                ]
            );
    }
}