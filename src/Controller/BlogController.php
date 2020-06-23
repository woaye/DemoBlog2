<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /*
     Symfony fonctionne tjs avec un systeme de rootage.
      une methode  d' 1 controlleur ser aexecité dans l url
     ex http://localhost:8000/blog  cela fait appel à la methode controller
      et execute la methode index()
      synfony se sert des annotations qui doivent etre dans 4 asterix   
    */
    
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
  
    }


        // home() : méthode 

    /**
     * @Route("/", name="home")
     */

    public function home()
    {
        return $this->render('blog/home.html.twig', [

            'title' => 'Bienvenu sur le blog Synfony',
            'age' => 25
        ]);


        }


        // voir le détail d1 article//
    /**
     * @Route("/blog/12", name= "blog_show")
     */
    public function show()
    {
        return $this->render('blog/show.html.twig');
    }
}



