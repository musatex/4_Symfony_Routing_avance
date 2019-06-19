<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;



class BlogController extends AbstractController
{
 /**
     * @Route("/blog/show/{slug}", requirements={"slug"="[a-z0-9-\.:\/\/=&]+"},
     *     name="blog_show")
     */
    public function show(string $slug='Article Sans Titre')
    {
        $title = ucwords(str_replace('-', ' ', $slug));
        return $this->render('blog/show.html.twig', [
            'slug' => $title,
        ]);
    }
}