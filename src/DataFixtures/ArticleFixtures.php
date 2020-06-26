<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;





class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <=10; $i++)
        {
             $article = new Article;

             $article->setTitle("Titre de l'artcile n°$i" )
               ->setContent("<p>Contenu de l'article n°$i</p>")
               ->setImage("https://picsum.photos/seed/picsum/200/200")
              
               ->setCreateAt(new \DateTime());


               $manager->persist($article);// prepare la requete//

        }

        $manager->flush();// libere la requete//
    }


}


