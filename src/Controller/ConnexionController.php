<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ConnexionController
 * @Route("/Connexion/")
 * @package App\Controller
 */
class ConnexionController extends Controller
{

    /**
     * @Route("subscribe", name="connexion_subscribe", methods={"GET", "POST"})
     */
    public function subscribe(EntityManagerInterface $entityManager, Request $request, Session $session, UserPasswordEncoderInterface $encoder) {

        // Entité à inflater
        $user = new User();

        // Formulaire de recherche
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            // encodage du password
            $pw = $encoder->encodePassword($user, $user->getPlainPW());
            $user->setPassword($pw);
            $user->setPlainPW("");

            // Message de confirmation
            $this->addFlash("success", "Inscription effectuée avec succès, veuillez vous connecter !");

            // Enregistrement dans la BDD
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection
            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $this->get('App\Security\Authenticator'),
                    'main'
                );
        }elseif ($formUser->isSubmitted() && !$formUser->isValid()){
            $this->addFlash("danger", "Raté !");
        }



        return $this->render('Subscribe.html.twig', ["formUser" => $formUser->createView()]);
    }

}