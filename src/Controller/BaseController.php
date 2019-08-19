<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BaseController
 * @Route("/Base/")
 *
 * @package App\Controller
 */
class BaseController extends Controller
{

    /**
     * @Route("Test")
     */
    public function showBase(){

        return $this->render("base.html.twig");
    }

}