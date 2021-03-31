<?php

namespace App\Controller;

use App\Entity\MotsInterdis;
use App\Form\MotsInterdisType;
use App\Repository\MotsInterdisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mots/interdis")
 */
class MotsInterdisController extends AbstractController
{
    /**
     * @Route("/", name="mots_interdis_index", methods={"GET"})
     */
    public function index(MotsInterdisRepository $motsInterdisRepository): Response
    {
        return $this->render('mots_interdis/index.html.twig', [
            'mots_interdis' => $motsInterdisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mots_interdis_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $motsInterdi = new MotsInterdis();
        $form = $this->createForm(MotsInterdisType::class, $motsInterdi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($motsInterdi);
            $entityManager->flush();

            return $this->redirectToRoute('mots_interdis_index');
        }

        return $this->render('mots_interdis/new.html.twig', [
            'mots_interdi' => $motsInterdi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mots_interdis_show", methods={"GET"})
     */
    public function show(MotsInterdis $motsInterdi): Response
    {
        return $this->render('mots_interdis/show.html.twig', [
            'mots_interdi' => $motsInterdi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mots_interdis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MotsInterdis $motsInterdi): Response
    {
        $form = $this->createForm(MotsInterdisType::class, $motsInterdi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mots_interdis_index');
        }

        return $this->render('mots_interdis/edit.html.twig', [
            'mots_interdi' => $motsInterdi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mots_interdis_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MotsInterdis $motsInterdi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motsInterdi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($motsInterdi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mots_interdis_index');
    }
}
