<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Pages;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewController extends AbstractController
{
    /**
     * @Route("/fr/{route}", requirements={"slug"=".*"}, name="vue")
     */
    /*public function index(): Response
    {
        return $this->render('vue/index.html.twig', [
            'controller_name' => 'VueController',
        ]);
    }*/

    /**
     * @Route("/fr", name="home")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $page = $entityManager->getRepository(Pages::class)->findOneBy(['slug' => "index"]);

        return $this->render('base.html.twig', [
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
            'controller_name' => 'ViewController',
        ]);
    }

    /**
     * @Route("/fr/{slug}", name="page_view")
     */
    public function page_view(String $slug)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $page = $entityManager->getRepository(Pages::class)->findOneBy(['slug' => $slug]);

        $message = "Not Found";
        $previous = null;

        // Rendu Page d'accueil 
        // -----------------------------/
        if($slug == "index"){
            return $this->redirectToRoute('home');
        }

        // Rendu Page
        // -----------------------------/
        if($page == null){
            return new NotFoundHttpException($message, $previous);
            return false;
        }

        return $this->render('base.html.twig', [
            'controller_name' => 'ViewController',
            'slugs' => $page,
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
        ]);
    }

    /**
     * @Route("/fr/blog/{post}", name="post_view")
     */
    public function post_view(String $post){
        $entityManager = $this->getDoctrine()->getManager();
        $page = $entityManager->getRepository(Articles::class)->findOneBy(["slug" => $post]);
        
        return $this->render('post.html.twig', [
            'controller_name' => 'ViewController',
            'article' => $page,
            'meta_title' => $page->getMetaTitle(),
            'meta_description' => $page->getMetaDescription(),
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function RedirectToHomepage()
    {
        return $this->redirectToRoute('home');
    }
}
