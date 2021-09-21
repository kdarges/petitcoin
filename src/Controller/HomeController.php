<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator)
    {
        $annonces = $paginator->paginate(
            $donnees = $annonceRepository->findByExampleField(),
            $request->query->getInt('page', 1),
            9 // nb article par page
        );

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

      /**
     * @Route("/", name="/")
     */
    public function home(AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator)
    {
        $annonces = $paginator->paginate(
            $donnees = $annonceRepository->findByExampleField(),
            $request->query->getInt('page', 1),
            9 // nb article par page
        );

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}


