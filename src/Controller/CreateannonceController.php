<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Service\FileUploader;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/createannonce")
 */
class CreateannonceController extends AbstractController
{
    /**
     * @Route("/", name="createannonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('createannonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="createannonce_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader)
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $annonce->setImage($imageFileName);
            }

            $annonce->setFkUser($this->getUser());
            $annonce->setDate(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('createannonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="createannonce_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('createannonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="createannonce_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('createannonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('createannonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="createannonce_delete", methods={"POST"})
     */
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('createannonce_index', [], Response::HTTP_SEE_OTHER);
    }
}
