<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Pages;
use App\Entity\Users;
use App\Form\AddArticleType;
use App\Form\AddPagesType;
use App\Form\CommonBlockType;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Leafo\ScssPhp\Compiler;

/*
    * ADMINISTRATION
    * PAGES
    * ARTICLES
    * UTILISATEURS
    * EN-TÊTE DU SITE
    * PIED DE PAGE DU SITE
*/

class AdminController extends AbstractController
{

    /******************************* ADMINISTRATION *******************************/
     
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $pages = $entityManager->getRepository(Pages::class)->findBy(array(), array("id" => "DESC"), 5, null);
        $articles = $entityManager->getRepository(Articles::class)->findBy(array(), null, 5, null);
        $users = $entityManager->getRepository(Users::class)->findBy(array(), null, 5, null);

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'pages' => $pages,
            'articles' => $articles,
            'users' => $users
        ]);
    }



    /******************************* PAGES *******************************/ 

    /**
     * @Route("/admin/pages-site", name="pages_site")
     */
    public function pages_site(){
        $entityManager = $this->getDoctrine()->getManager();
        $pages = $entityManager
                    ->getRepository(Pages::class)
                    ->findBy(
                        array(),
                        array("id" => "ASC")
                    );

        return $this->render('admin/pages-list.html.twig', [
            'controller_name' => 'AdminController',
            'pages' => $pages
        ]);
    }

    /**
     * @Route("/admin/add-page", name="add_page")
     */
    public function add_page(Request $request): Response{

        $form = $this->createForm(AddPagesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $page = new Pages();
            $slugPage = new Slugify();
            $slugPageStr = $slugPage->slugify($data["page_title"]);
            $page->setName($data["page_title"]);
            $page->setFileName($slugPageStr);
            $page->setBlockedPage(0);

            //Création de l'URL
            if($data["page_url"] == null){
                $page->setSlug($slugPageStr);
            } else {
                $page->setSlug($data["page_url"]);
            }

            //Création de la Meta Title
            if($data["page_meta_title"] == null){
                $page->setMetaTitle($data["page_title"]);
            } else {
                $page->setMetaTitle($data["page_meta_title"]);
            }

            // On vérifie si l'URL existe pas et on crée la page
            $entityManager = $this->getDoctrine()->getManager();
            $verifySlug = $entityManager->getRepository(Pages::class)->findOneBy(["slug" => $slugPageStr]);
            if($verifySlug == null){
                //Envoie des données de la page
                $entityManager->persist($page);
                $entityManager->flush();
                //Création de la page
                $file = fopen("../templates/front/website/" . $slugPageStr . ".html.twig", "c+b");
                fwrite($file, $data["page_content"]);
            }

            //On redirige la page vers le formulaire d'ajout de page
            return $this->redirectToRoute('modify_page', array('slug' => $slugPageStr));
        }

        return $this->render('admin/add-page.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/admin/modify-page/{slug}", name="modify_page")
     */
    public function modify_page(Request $request, String $slug): Response
    {
        $dataFile = file_get_contents("../templates/front/website/".$slug.".html.twig");

        $form = $this->createForm(AddPagesType::class);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $pages = $entityManager->getRepository(Pages::class)->findOneBy(["fileName" => $slug]);
        $pageName = $pages->getName();
        $pageSlug = $pages->getSlug();
        $pageMetaTitle = $pages->getMetaTitle();
        $pageMetaDesc = $pages->getMetaDescription();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $pages->setName($data["page_title"]);
            $pages->setMetaTitle($data["page_meta_title"]);
            $pages->setMetaDescription($data["page_meta_desc"]);

            if($data["page_url"] != null){
                $pages->setSlug($data["page_url"]);
            }

            $entityManager->persist($pages);
            $entityManager->flush();

            //Création de la page
            $filesystem = new Filesystem();
            $filesystem->remove(['../templates/front/website/' . $slug . '.html.twig']);
            $file = fopen("../templates/front/website/" . $slug . ".html.twig", "c+b");
            fwrite($file, $data["page_content"]);

            return $this->redirectToRoute('modify_page', array('slug' => $slug));
        }

        return $this->render('admin/modify-page.html.twig', [
            'form' => $form->createView(),
            'pages' => $pages,
            'pageName' => $pageName,
            'pageSlug' => $pageSlug,
            'pageMetaTitle' => $pageMetaTitle,
            'pageMetaDesc' => $pageMetaDesc,
            'dataFile' => $dataFile,
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/admin/delete-page/{id}", name="delete_page")
     */
    public function delete_page(int $id)
    {
        $filesystem = new Filesystem();
        $entityManager = $this->getDoctrine()->getManager();
        $page = $entityManager->getRepository(Pages::class)->find($id);
        $pageFile = $page->getFileName();

        $entityManager->remove($page);
        $entityManager->flush();

        $filesystem->remove(['../templates/front/website/' . $pageFile . '.html.twig']);

        return $this->redirectToRoute('pages_site');
    }




    /******************************* ARTICLES *******************************/ 

    /**
     * @Route("/admin/articles-site", name="articles_site")
     */
    public function articles_site()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articles = $entityManager->getRepository(Articles::class)->findAll();

        return $this->render('admin/articles-list.html.twig', [
            'controller_name' => 'AdminController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/add-article", name="add_article")
     */
    public function add_article(Request $request){

        $form = $this->createForm(AddArticleType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            // Initialisation des informations
            $slugify = new Slugify();
            $fileName = $slugify->slugify($data['article_title']);

            // Envoi des données vers MySQL
            $article = new Articles();
            $article->setName($data['article_title']);
            if($data['article_slug'] == null){
                $article->setSlug($fileName);
            } else {
                $article->setSlug($data['article_slug']);
            }
            if($data['article_metatitle'] == null){
                $article->setMetaTitle($data['article_title']);
            } else {
                $article->setMetaTitle($data['article_metatitle']);
            }
            $article->setMetaDesc($data['article_metadesc']);
            $article->setFileName($fileName);

            // Création du fichier
            $entityManager = $this->getDoctrine()->getManager();
            $verifySlug = $entityManager->getRepository(Pages::class)->findOneBy(["slug" => $data['article_slug']]);
            if($verifySlug == null){
                //Envoie des données de la page
                $entityManager->persist($article);
                $entityManager->flush();
                //Création de la page
                $file = fopen("../templates/front/blog/" . $fileName . ".html.twig", "c+b");
                fwrite($file, $data["article_content"]);
            }

            // Redirection à la liste des articles
            return $this->redirectToRoute('articles_site');
        }

        return $this->render('admin/add-article.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/admin/modify-article/{slug}", name="modify_article")
     */
    public function modify_article(Request $request, String $slug): Response
    {
        $dataFile = file_get_contents("../templates/front/blog/".$slug.".html.twig");

        $form = $this->createForm(AddArticleType::class);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Articles::class)->findOneBy(["slug" => $slug]);
        $articleName = $article->getName();
        $articleSlug = $article->getSlug();
        $articleMetaTitle = $article->getMetaTitle();
        $articleMetaDesc = $article->getMetaDesc();

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $article->setName($data["article_title"]);
            $article->setMetaTitle($data["article_metatitle"]);
            $article->setMetaDesc($data["article_metadesc"]);

            //Contrôle du champ URL
            if($data["article_slug"] != null){
                $article->setSlug($data["article_slug"]);
                $slug = $data["article_slug"];
            }

            $entityManager->persist($article);
            $entityManager->flush();

            //Création de la page
            $filesystem = new Filesystem();
            $filesystem->remove(['../templates/front/blog/' . $slug . '.html.twig']);
            $file = fopen("../templates/front/blog/" . $slug . ".html.twig", "c+b");
            fwrite($file, $data["article_content"]);

            return $this->redirectToRoute('modify_article', array('slug' => $slug));
        }

        return $this->render('admin/modify-article.html.twig', [
            'form' => $form->createView(),
            'dataFile' => $dataFile,
            'articleName' => $articleName,
            'articleSlug' => $articleSlug,
            'articleMetaTitle' => $articleMetaTitle,
            'articleMetaDesc' => $articleMetaDesc,
            'controller_name' => 'AdminController'
        ]);
    }

    /**
     * @Route("/admin/delete-article/{id}", name="delete_article")
     */
    public function delete_article(int $id)
    {
        $filesystem = new Filesystem();
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Articles::class)->find($id);
        $articleFile = $article->getFileName();

        $entityManager->remove($article);
        $entityManager->flush();

        $filesystem->remove(['../templates/front/blog/' . $articleFile . '.html.twig']);

        return $this->redirectToRoute('articles_site');
    }




    /******************************* UTILISATEURS *******************************/ 

    /**
     * @Route("/admin/users-list", name="users_list")
     */
    public function users_list(){

        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(Users::class)->findAll();

        return $this->render('admin/users-list.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users
        ]);
    }



    /******************************* EN-TÊTE DU SITE *******************************/
    /**
     * @Route("/admin/header-manage", name="header_manage")
     */
    public function header_manage(Request $request){

        $dataFile = file_get_contents("../templates/front/blocks/header.html.twig");

        $form = $this->createForm(CommonBlockType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            $filesystem = new Filesystem();
            $filesystem->remove(['../templates/front/blocks/header.html.twig']);
            $file = fopen("../templates/front/blocks/header.html.twig", "c+b");
            fwrite($file, $data["block_content"]);

            return $this->redirectToRoute('header_manage');
        }

        return $this->render('admin/manage-header.html.twig', [
            'form' => $form->createView(),
            'dataFile' => $dataFile,
            'controller_name' => 'AdminController',
        ]);
    }

    

    /******************************* PIED DE PAGE DU SITE *******************************/
    /**
     * @Route("/admin/footer-manage", name="footer_manage")
     */
    public function footer_manage(Request $request){

        $dataFile = file_get_contents("../templates/front/blocks/footer.html.twig");

        $form = $this->createForm(CommonBlockType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            $filesystem = new Filesystem();
            $filesystem->remove(['../templates/front/blocks/footer.html.twig']);
            $file = fopen("../templates/front/blocks/footer.html.twig", "c+b");
            fwrite($file, $data["block_content"]);

            return $this->redirectToRoute('footer_manage');
        }

        return $this->render('admin/manage-footer.html.twig', [
            'form' => $form->createView(),
            'dataFile' => $dataFile,
            'controller_name' => 'AdminController',
        ]);
    }
}
