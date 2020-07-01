<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)

 
    {

    // pour inserer en sql user , instancier un objet issu de l identity User
    // entité user reflet la table sql
        $user =  new User;

        // on appel la classe registrationType afin de créer le formulaire d'incription
        $form = $this ->createForm(RegistrationType::class, $user);
        
        dump($request);

        // handleRequest ceupere les donnnées saisies dans le form et le srenvois directement dans les setteurs


        $form->handleRequest($request);

        //si le form a bien été valié (isSubmitted) et que les setteurs  sont correctment remplis
        // alors on crée le IF
        if($form->isSubmitted() && $form -> isValid())
        {


            // on transmet la methode encodepassword() de l interface User password 

            // hash contient le mot à encoder 
           $hash-> $encoder->encodePassword($user, $user->getPassword()); 

           $user->setPassword($hash);
           $manager->persist($user);  // on prepare insertion
           $manager->flush(); // on execute la requete

           $this->addFlash('success', 'Feliciation',  'Vous etes connecté.');

          return $this->redirectToRoute('security_login');

         }

        return $this->render('security/registration.html.twig', [
            'form' => $form ->createView()

        ]);
       
       
        }


        /**
         * @Route("/connexion", name= "security_login")
         */

         public function login()
         {
                     return $this->render('security/login.html.twig');
         
                    }

             /**
              * @Route("/deconnexion", name="security_logout")
              */
              public function logout()
              {

              // cette méthode permet de se deconnecter //
              }
    }



