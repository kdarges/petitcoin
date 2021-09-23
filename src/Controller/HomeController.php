<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\AnnonceRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
    * @Route("/", name="/")
    */
    public function home(VilleRepository $villeRepository, AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator)
    {
        $query = $_GET ? "req.fk_ville = " . $_GET['ville'] : '1=1';
        $annonces = $paginator->paginate(
            $donnees = $annonceRepository->sortAnnounceBy($query),
            $request->query->getInt('page', 1),
            6 // nb article par page
        );

        $test = $villeRepository->getDpt();

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
            'villes' => $villeRepository->getDpt(),
        ]);
    }

    /**
    * @Route("/home", name="home")
    */
    public function index(AnnonceRepository $annonceRepository, Request $request, PaginatorInterface $paginator)
    {
        $query = $_GET ? "req.fk_ville = " . $_GET['dpt'] : '1=1';
        $annonces = $paginator->paginate(
            $donnees = $annonceRepository->sortAnnounceBy($query),
            $request->query->getInt('page', 1),
            6 // nb article par page
        );

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}