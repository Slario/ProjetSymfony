<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseController
 * @Route("")
 *
 * @package App\Controller
 */
class BaseController extends Controller
{

    /**
     * @Route("", name="main_accueil", methods={"GET"})
     */
    public function accueil(){

        return $this->render("Accueil.html.twig");
    }

    /**
     * @Route("Recherche", name="main_recherche", methods={"GET"})
     */
    public function recherche(){

        return $this->render("Recherche.html.twig");

    }

    /**
     * @Route("Annonce", name="main_annonce", methods={"GET"})
     */
    public function annonce(){

        return $this->render("Annonce.html.twig");

    }

    /**
     * @Route("CGU", name="main_CGU", methods={"GET"})
     */
    public function CGU(){

        return $this->render("CGU.html.twig");

    }



    /**
     * @Route("Deposer", name="main_deposer", methods={"GET"})
     */
    public function deposer(){

        return $this->render("Deposer.html.twig");

    }

    /**
     * @Route("FAQ", name="main_FAQ", methods={"GET"})
     */
    public function FAQ(){

        return $this->render("FAQ.html.twig");

    }

    /**
     * @Route("MesAnnonces", name="main_mesAnnonces", methods={"GET"})
     */
    public function mesAnnonces(){

        return $this->render("MesAnnonces.html.twig");

    }

    /**
     * @Route("MesFavoris", name="main_mesFavoris", methods={"GET"})
     */
    public function mesFavoris(){

        return $this->render("MesFavoris.html.twig");

    }

}