<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Reaction;
use App\Form\PostType;
use App\Form\ReactionType;
use App\Repository\MotsInterdisRepository;
use App\Repository\PostRepository;
use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET","POST"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findutl('2'),
        ]);
    }
    /**
     * @Route("/liste", name="post_liste", methods={"GET","POST"})
     */
    public function liste(PostRepository $postRepository): Response
    {
        return $this->render('forum.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }



    /**
     * @Route("/recherche", name="recherhe", methods={"GET","POST"})
     */
    public function recherche(PostRepository $postRepository,Request $request): Response
    {
        return $this->render('forum.html.twig', [
            'posts' => $postRepository->recherche($request->request->get("recherche")),
        ]);
    }




    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request,PostRepository $postRepository,motsInterdisRepository $motsInterdisRepository): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $post->setDatepost(new \DateTime('@'.strtotime('now')));

        $post->setTitres($request->request->get('titre'));
        $post->setIdUtl(2);
        $post->setsolution(0);
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
        $post->setMessage($message);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
        return $this->render('forum.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);

    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post ,ReactionRepository  $reactionRepository): Response
    {
        return $this->render('forum2.html.twig', [
            'post' => $post,
            'reactions' => $reactionRepository->findbb($post->getId())
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/valide", name="post_valide", methods={"GET","POST"})
     */
    public function valide(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $post->setsolution(1);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');



    }
    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
