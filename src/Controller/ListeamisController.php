<?php

namespace App\Controller;

use App\Entity\Listeamis;
use App\Form\ListeamisType;
use App\Repository\ListeamisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/listeamis")
 */
class ListeamisController extends AbstractController
{
    /**
     * @Route("/", name="listeamis_index", methods={"GET"})
     */
    public function index(ListeamisRepository $listeamisRepository): Response
    {
        return $this->render('listeamis/index.html.twig', [
            'listeamis' => $listeamisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="listeamis_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listeami = new Listeamis();
        $form = $this->createForm(ListeamisType::class, $listeami);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listeami);
            $entityManager->flush();

            return $this->redirectToRoute('listeamis_index');
        }

        return $this->render('listeamis/new.html.twig', [
            'listeami' => $listeami,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listeamis_show", methods={"GET"})
     */
    public function show(Listeamis $listeami): Response
    {
        return $this->render('listeamis/show.html.twig', [
            'listeami' => $listeami,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listeamis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Listeamis $listeami): Response
    {
        $form = $this->createForm(ListeamisType::class, $listeami);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listeamis_index');
        }

        return $this->render('listeamis/edit.html.twig', [
            'listeami' => $listeami,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listeamis_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Listeamis $listeami): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listeami->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listeami);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listeamis_index');
    }
}
