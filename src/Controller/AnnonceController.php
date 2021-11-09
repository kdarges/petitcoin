<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AnnonceType;

class AnnonceController extends AbstractController
{
    /**
    * @Route("/annonce/{id}", name="annonce")
    */
    public function show(Annonce $annonces): Response
    {
        return $this->render('annonce/index.html.twig', ['annonces' => $annonces]);
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
    
    /**
    * @Route("/mesannonces/{id}/edit", name="annonce_edit", methods={"GET","POST"})
    */
    public function edit(Request $request, Annonce $annonce): Response {

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();
            
            return $this->redirectToRoute('mesannonces', [], Response::HTTP_SEE_OTHER);
            
        }
        return $this->render('annonce/editannonce.html.twig', [
            'form' => $form->createView(),
            'annonce' => $annonce,
            
        ]);
        
    }

    /**
    * @Route("/mesannonces/{id}/delete", name="annonce_delete", methods={"GET","POST"})
    */
    public function delete(Request $request, Annonce $annonce): Response{
        
        
        // if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        // }
        
        return $this->redirectToRoute('mesannonces', [], Response::HTTP_SEE_OTHER);
    }
    
    
    
    
}
