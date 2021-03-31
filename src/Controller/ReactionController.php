<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Reaction;
use App\Form\ReactionType;
use App\Repository\MotsInterdisRepository;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
/**
 * @Route("/reaction")
 */
class ReactionController extends AbstractController
{

    /**
     * @Route("/show", name="show", methods={"GET"})
     */
    public function index(ReactionRepository $reactionRepository): Response
    {
        return $this->render('forum.html.twig', [
            'reactions' => $reactionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="reaction_new", methods={"GET","POST"})
     */
    public function new1(PostRepository $postRepository, Request $request,ReactionRepository  $reactionRepository,motsInterdisRepository $motsInterdisRepository): Response
    {
        $reaction = new Reaction();
    $post =new Post();
$post =$postRepository->find($request->request->get('id'));
        $form = $this->createForm(reactionType::class, $reaction);
        $form->handleRequest($request);
        $reaction->setPost($post);
        $reaction->setIdUtli(3);
        $phrase=  $request->request->get('message');
        $message="";

        /* caractères que l'on va remplacer (tout ce qui sépare les mots, en fait) */
        $aremplacer = array(",",".",";",":","!","?","(",")","[","]","{","}","\"","'"
        ," ");

        /* ... on va les remplacer par un espace, il n'y aura donc plus dans $phrase
      que des mots et des espaces */

        $enremplacement = " ";


        /* on fait le remplacement (comme dit ci-avant), puis on supprime les espaces de
        // début et de fin de chaîne (trim) */
        $sansponctuation = trim(str_replace($aremplacer, $enremplacement, $phrase));



        /* on coupe la chaîne en fonction d'un séparateur, et chaque élément est une
        // valeur d'un tableau */
        $separateur = "#[ ]+#"; // 1 ou plusieurs espaces
        $mots = preg_split($separateur, $sansponctuation);
        $interdis=  $motsInterdisRepository->findAll();
        foreach($mots as $valeur)
        {
            foreach ($interdis as $interdi)
            {if($interdi->getMots()==$valeur)
                $valeur='****';
            }
            $message=  $message." ".$valeur;
        }
        $reaction->setMessage($message);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reaction);
        $entityManager->flush();
        return $this->render('forum2.html.twig', [
            'post' => $post,
            'reactions' => $reactionRepository->findbb(45)
        ]);

    }

    /**
     * @Route("/{id}", name="reaction_show", methods={"GET"})
     */
    public function show(Reaction $reaction): Response
    {
        return $this->render('reaction/show.html.twig', [
            'reaction' => $reaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reaction_edit", methods={"GET","reaction"})
     */
    public function edit(Request $request, Reaction $reaction): Response
    {
        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reaction_index');
        }

        return $this->render('reaction/edit.html.twig', [
            'reaction' => $reaction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reaction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reaction $reaction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reaction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_liste');

    }
}
