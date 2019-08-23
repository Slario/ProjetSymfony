<?php


namespace App\Controller;



use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 *
 * @Route("/category/")
 */
class CategoryController extends Controller
{

    /**
     * @Route("create", name="category_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager){

        // Entité à inflater
        $cate = new Category();

        // Formulaire de recherche
        $form = $this->createForm(CategoryType::class, $cate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Message de confirmation
            $this->addFlash("success", "Catégorie créée avec succès");

            // Enregistrement dans la BDD
            $entityManager->persist($cate);
            $entityManager->flush();

            // Redirection
            return $this->redirectToRoute('category_create');
        }

        return $this->render("/category/create.html.twig", ['form' => $form->createView()]);

    }

}