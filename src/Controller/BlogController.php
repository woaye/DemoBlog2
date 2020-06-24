<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function index(ArticleRepository $repo)   
    {


        /* un des principes de symfony est une injection de dépendances 
        par exemple pr la metode index (), elle a besoin de l'Article Repository pour fonctionner
        donc on injecte une dépendance en argument de la méthode index(), on impose un objet issu de la classe Repository
         plus besoin d efaire appel à DOCTRINE
         $REPO DONNE ACCÈS A TOUTES LES MÉTHODES 
         plus rapide 


        /*
        Pour sélectionner des données en BDD nous avons besoin de la classe Repositoty de la class Artcle
        une classe Repository permet uniquement de sélectionner des données en bdd (requete SQL)
        On a  besoin de l'ORM DOCTRINE pour faire la relation entre la bdd et le controller (getDoctrine)
        $repo est un objet issu de la classe ArtcileRepository elle contient des méthodes pré définies par 
        Symfony permettant  de sélectionner des données en BDD

        findAll() est une méthode de la classe ArticleRepository permettant de sélectionner l'ensemble de la table SQL
        donc ici la table

        */
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        dump($articles);// var_dump()

        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles'=>$articles //renvoie le template index.html.twig sékléctionné en bdd($article) nous allons avec twig sur le le template 
        
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
//  creer une new route (article) en bdd
           /**
            * @Route("/blog/new", name="blog_create")
            */
                public function create()
                {
                   return $this->render('blog/create.html.twig');

                }


                // voir le détail d1 article//
            /**
             * @Route("/blog/{id}", name= "blog_show")
             */
            public function show(ArticleRepository $repo, $id) 
         //show(ArticleRepository $repo) -->$repo est une variable de réception issu de la callse Article Repository et à l'interieur de la methode
         // variable de réception id réceptionné de la bdd(parametre de type id)
        // lorsque nous transmettons à l url une route par exemple */blog/  un envoi dans un id connu dans l url
        //cela veut dire que nous avons acces a l id à l'inrerieur de la méthode show
        //le but est de sélectionner les données ds la bdd recupéré ds le parametre
        //nous avons de l Article Repository afin de le sélectionner
        //la methode find () permet de sélectionner en bdd avec un argument de type id
        // DOCTRINE fait ensuite son role, c a dire recuperer la requete de selction pour le xecuter en bdd
        // et ele retourne le résultat au controller
        //$repo est un objet de Classe repository

            {
                // $repo = $this->getDoctrine()->getRepository(Article::class);

                $article = $repo->find($id);// id 1 argument en méthode
                dump($article);

                return $this->render('blog/show.html.twig', [
                    'article' => $article // on envoit avec le template show.twif l article sélectionné en bdd
                ]);

                // arguments  render (rendu vers template)//
            }


        }







