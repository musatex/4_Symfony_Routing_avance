<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class BlogController extends AbstractController 

{

    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */

    public function index(): Response
    {
        // you can fetch the articles via $this->getDoctrine()

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }
        return $this->render('blog/index.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/show/{slug<^[a-z0-9-]+$>}",
*          defaults={"slug" = null},
*          name="blog_show")
     *  @return Response A response instance
     */

    public function show($slug) : Response 
    {
    
        if (!$slug) {
            throw $this->createNotFoundException(
                'No slug has been sent to find an article in article\'s table.'
            );
        }

        $slug = preg_replace('/-/',' ', ucwords(trim(strip_tags($slug)), "-"));

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render('blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }
    
    /**
    * Show articles from Category
    *
    * @Route("/category/{category}", name="blog_show_category")
    *
    * @return Response A response instance
    */
    public function showByCategory(string $category) : Response
    {
        $category = $this
            ->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($category)
        ;

        $articles = $this
            ->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(array('category'=> $category),null, 3)
        ;

        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'category' => $category,
            ]
        );
    }
    
    /**
     * Show all articles from one Category
     *
     * @Route("/category/{name}/all", name="blog_show_allbyCategory")
     * @return Response A response instance
     */

    public function showAllByCategory(Category $category) : Response
    {
        $categories = $category->getArticles();

        return $this->render(
            'blog/showAllByCategory.html.twig',
            [
                'category' => $categories,
            ]
        );
    }
}