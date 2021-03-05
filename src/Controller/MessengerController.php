<?php

namespace App\Controller;

use App\Entity\Messenger;
use App\Form\MessengerType;
use App\Repository\MessengerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messenger")
 */
class MessengerController extends AbstractController
{
    /**
     * @Route("/", name="messenger_index", methods={"GET"})
     */
    public function index(MessengerRepository $messengerRepository): Response
    {
        return $this->render('messenger/new.html.twig', [
            'messengers' => $messengerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="messenger_new", methods={"GET","POST"})
     */
    public function new(Request $request,MessengerRepository $messengerRepository): Response
    {
        $messenger = new Messenger();
        $form = $this->createForm(MessengerType::class, $messenger);
        $form->handleRequest($request);

        $messenger->setIdExp(1);
        $messenger->setIdRecp(2);
        $messenger->setDatee(new \DateTime('@'.strtotime('now')));
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messenger);
            $entityManager->flush();

            return $this->redirectToRoute('messenger_new');
        }

        return $this->render('messenger/new.html.twig', [
            'messenger' => $messenger,
            'messengers' => $messengerRepository->findByidexp(1,2),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="messenger_show", methods={"GET"})
     */
    public function show(Messenger $messenger): Response
    {
        return $this->render('messenger/new.html.twig', [
            'messenger' => $messenger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="messenger_edit", methods={"GET","POST"})
     */

    /**
     * @Route("/{id}", name="messenger_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Messenger $messenger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messenger->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messenger);
            $entityManager->flush();
        }

        return $this->redirectToRoute('messenger_new');
    }
}
