<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\AdType;
use App\Form\ResearchType;
use App\Form\UserType;
use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ad")
 */
class AdController extends Controller
{
    /**
     * @Route("/", name="ad_index", methods={"GET", "POST"})
     */
    public function index(Request $request, AdRepository $adRepository): Response
    {

        $search = new Ad();

        $form = $this->createForm(ResearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ads = $adRepository->findByTitleOrCategory($search->getTitle(), $search->getCategory());

            return $this->render('ad/index.html.twig', [
                'ads' => $ads,
                'form' => $form->createView()
            ]);
        }

        return $this->render('ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
            'form' => $form->createView()

        ]);

    }

    /**
     * @Route("/search/{category}/{title}", name="ad_search", methods={"GET", "POST"})
     */
    public function search(Request $request, AdRepository $adRepository): Response
    {

        $ad = new Ad();
        $search = new Ad();

        $form = $this->createForm(ResearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ads = $adRepository->findByTitleOrCategory($ad->getTitle(), $ad->getCategory());

            return $this->render('ad/index.html.twig', [
                'ads' => $ads,
                'form' => $form->createView()
            ]);
        }

        return $this->render('ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/new", name="ad_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ad = new Ad();
        $ad->setOwner($this->getUser());

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mine", name="ad_mine", methods={"GET"})
     */
    public function mesAnnonces(AdRepository $adRepository): Response
    {
        return $this->render('ad/mine.html.twig', [
            'ads' => $adRepository->findBy(['owner' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/fav", name="ad_fav", methods={"GET"})
     */
    public function mesFavoris(AdRepository $adRepository): Response
    {
        return $this->render('ad/favorites.html.twig', [
            'ads' => $this->getUser()->getFavorites()
        ]);
    }

    /**
     * @Route("/{id}", name="ad_show", methods={"GET"})
     */
    public function show(Ad $ad): Response
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ad_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ad_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad_index');
    }

    /**
     * @Route("/addFav/{id}", name="ad_favo", methods={"GET"})
     */
    public function addToFavorites(Request $request, AdRepository $adRepository, UserRepository $userRepository, Ad $idAd, EntityManagerInterface $entityManager): Response
    {
        $ad = $adRepository->findOneBy(['id' => $idAd]);
        $u = $userRepository->findOneBy(['id' => $this->getUser()->getId()]);
        $u->addFavorite($ad);
        $entityManager->persist($u);
        $entityManager->flush();


        return $this->redirectToRoute('ad_index');
    }

    /**
     * @Route("/deleteFav/{id}", name="delete_favo", methods={"GET"})
     */
    public function deleteFromFavorites(Request $request, AdRepository $adRepository, UserRepository $userRepository, Ad $idAd, EntityManagerInterface $entityManager): Response
    {
        $ad = $adRepository->findOneBy(['id' => $idAd]);
        $u = $this->getUser();
        $u->deleteFavorite($ad);
        $entityManager->persist($u);
        $entityManager->flush();


        return $this->redirectToRoute('ad_index');

    }
}


