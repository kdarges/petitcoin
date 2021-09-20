<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use App\Entity\User;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonce/{id}", name="annonce")
     */
    public function show(int $id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Annonce::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        return $this->render('annonce/index.html.twig', ['product' => $product,]);
    }

    /**
     * @Route("/mesannonces", name="mesannonces")
     */

    public function mesannonces(): Response {
        $user = $this->getUser();
        $annonces = $user->getAnnonces();

        return $this->render('annonce/mesannonces.html.twig', [
            'annonces' => $annonces,
        ]);


    }
}
