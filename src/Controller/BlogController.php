<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            * @Route("/blog/{id}/edit/", name="blog_edit")
            */
           
                public function form(Article $article = null,  Request $request, EntityManagerInterface $manager)
                {

                /* request est une classe pré defini de symfony qui stocke ttes les données par les super globales
                ($_post/$_get...) nous avons acces aux données du formulaire par $request
                la propriété $request représente la super globale $_post désigné ds le formulaire
                via $request
                pour insérer new article instancier la classe Entité Article pour un objet Article
                afin de rensegner ts le setteurs d l'objet $article
                EntityManager Interfaxe est  l'interface entitymanager qui execcute le requete sql
                redirectToRoute() est une méthode pré définie ds symfony qui permet de rédiriger
                apres insertion vers la route blog_show  et transfert les méthodes de l'id de l article à envoyer en url

                */
                
                       dump($request);
                 

                //     if($request->request->count() > 0)
                //     {
                //         $article = new Article;
                //         //get() : methode $_post 

                //         $article->setTitle($request->request->get('title'))
                //              ->setContent($request->request->get('content'))
                //              ->setImage($request->request->get('image'))
                //              ->setCreateAt(new \DateTime());

                //              $manager->persist($article);
                //              $manager->flush();

                //              dump($article);

                //              return $this->redirecttoRoute('blog_show',[
                //                  'id' => $article->getId()
                //              ]);
                
                //     }




                // $form = $this->createFormBuilder($article)
                //         ->add('title')
                //         ->add('content')
                //         ->add('image')
                //         ->getForm();

             
               if(!$article)
               {
                $article = new Article; 
               }

                 $form = $this->createForm(ArticleType::class,$article);



                // $article->setTitle("titre")
                //   ->setContent("contenu");

// si l'articlen existe pas, ni defini, NULL, ca veut dire que l'iD a été transmis ds url donc c est une insertion
// alors on instancie la classe Article pr avoir $article null
// on entre da,ns le cas d'une insertion d'1 nouvel article
// on importe la classe permettant de créer le form / ajout/ modif article
//on envoi un 2 eme argument ds $article modifié ds le formulaire et destiné à remplir $article 
// la methode handleRequest permet de récupérer les valeurs  du form ds un contenu $request//
//afin de les envoyer ditectement ds les setteurs de l'objet $article
                 $form->handleRequest($request);

                 // si le form a bien étét soumis que l on a cliqué sur le boutton submit
                 // alors la condition est bien validée ds le If//



                 if($form->isSubmitted() && $form->isValid())
// afin de garder la date d'origine de création de l'article on controle l existnce de l'ID
//si l ID de l article  n'est pas défini, on l'envoi dans le DateTime dans le secteur de l'article pr création
// on entre ds la condition seulementds le cas de création d'1 article
                 {
                     if(!$article->getId())// une méthode prédéfinie en symfony qui permet d'inserer en bdd
                // (insert, delete..) elle contient tttes les requetes SQL (persist()| flush()
   // persist est une méthode issue de //
                     {
                         $article->setCreateAt(new\ DateTime);
                     }

                     $article->setCreateAt(new \DateTime);

                     $manager->persist($article);// on prepare 
                     $manager->flush();/// on push vers BDD

                     dump($article);
                     return $this->redirecttoRoute('blog_show',[
                                 'id' => $article->getId()
                           ]);
                 }


                 return $this->render('blog/create.html.twig', [
                     'formArticle'=> $form->createView(),
                     'editMode' => $article ->getId() !== null// si article est null pas de ID, sinon si l'article possede 1 id c une modification
                     // il n y a pas d insertion ds bdd

                 ]);


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







