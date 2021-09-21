<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use App\Entity\User;
use App\Entity\Categorie;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/{id}"), name="categorie")
     */

    public function show(int $id, AnnonceRepository $annonceRepository, CategorieRepository $categorierepository): Response {

        $idcategories = $categorierepository->findMyAnnouncebyCategory($id);
        $tutu = $annonceRepository->findByExampleField($id);
        return $this->render('categorie/index.html.twig', ['idcategories' => $idcategories, 'tutu' => $annonceRepository->findByExampleField($id)]);
    }
}
