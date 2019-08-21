<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConnexionController
 * @Route("/Connexion/")
 * @package App\Controller
 */
class ConnexionController extends Controller
{

    /**
     * @Route("", name="connexion_", methods={"GET", "POST"})
     */
    public function connexion(EntityManagerInterface $entityManager, Request $request, Session $session) {

        // Entité à inflater
        $user = new User();
        $user->setDateRegistered(new \DateTime());

        // Formulaire de recherche
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            // Message de confirmation
            $this->addFlash("success", "Connexion effectuée avec succès !");

            // Enregistrement dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();
            $session->set('user', $user);

            // Redirection
            return $this->redirectToRoute("connexion_");
        }

        return $this->render('Connexion.html.twig', ["formUser" => $formUser->createView()]);
    }

    /**
     * @Route("subscribe", name="connexion_subscribe", methods={"GET", "POST"})
     */
    public function subscribe(EntityManagerInterface $entityManager, Request $request, Session $session) {

        // Entité à inflater
        $user = new User();
        $user->setDateRegistered(new \DateTime());
        $user->setRole("STD");

        // Formulaire de recherche
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            // Message de confirmation
            $this->addFlash("success", "Inscription effectuée avec succès !");

            // Enregistrement dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();
            $session->set('user', $user);

            // Redirection
            return $this->redirectToRoute("connexion_subscribe");
        }
        //$this->addFlash("danger", "Raté !");

        return $this->render('Subscribe.html.twig', ["formUser" => $formUser->createView()]);
    }

}