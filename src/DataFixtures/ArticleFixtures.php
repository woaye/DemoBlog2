<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // la librairie FAKER permet d'inserer en BDD des fausses données , il genere en aleatoire
        //
        $faker = \Faker\Factory::create('fr_FR');

        // Création de 3 catégories
        for($i = 1; $i <= 3; $i++)
        {

            // on instancie l entité category afin de l'inserer en BDD
            $category = new Category;
           /// on appelle le ssetteurs de l'objet categorie 
           // sentence mathode () issu de l'objet faker permet de générer des phrases en aleatoires 
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());// CREE PARAGRAH 1 OU PLUSIEURS SI PARAGRAPHS

            $manager->persist($category);// prepare l insertion en bdd //

            // création entre 4 e 6 articles par catégorie

            for($j = 1; $j <= mt_rand(4,6); $j++)
            {   

                // on instanvie l'entité article afin d inserer  en BDD//
                $article = new Article;

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
                // on sépare les paragraphes créés par faker par des balises <p>
                $article->setTitle($faker->sentence())// SENTENCE PHRASES ALEATOIRES
                        ->setContent($content)
                        ->setImage($faker->imageUrl())
                        ->setCreateAt($faker->dateTimeBetween('-6 months'))
                        ->setCategory($category);// on relie nos articles aux articles crée en  bidimension


                $manager->persist($article);

                // Création entre 4 et 10 commentaires par article
                for($k = 1; $k <= mt_rand(4,10); $k++)
                {
                    $comment = new Comment;

                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';
                   

                    // ici nous faisons en sorte d avoir des dates et des commentaires coherents
                // c a dire la création des articles et date aujourd'hui
                    $now = new \Datetime;
                    $interval = $now->diff($article->getCreateAt()); // représente le temps en timestamp entre la date de création de l'article et maintenant
                    $days = $interval->days; // nombre de jour entre la date de création de l'article et maintenant
                    $minimum = '-' .$days . ' days';
                

                    // on instancie l' entité comment afin d inerer en BDD
                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreatedAt($faker->dateTimeBetween($minimum))
                            ->setArticle($article);  //on relie nos articles avce nos commentaires (clé etrangere)

                    $manager->persist($comment);  // on prepare a insertion des commentaires
                }
            }
        }

        $manager->flush();// on libere en envoi en BDD

    }
}


