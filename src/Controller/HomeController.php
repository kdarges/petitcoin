<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'annonces' => $annonceRepository->findByExampleField(),

        ]);
    }

      /**
     * @Route("/", name="/")
     */
    public function home(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'annonces' => $annonceRepository->findByExampleField(),
        ]);
    }
}


