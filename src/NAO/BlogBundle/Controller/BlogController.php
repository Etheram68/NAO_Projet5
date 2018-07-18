<?php

namespace NAO\BlogBundle\Controller;

use NAO\BlogBundle\Entity\Article;
use NAO\BlogBundle\Form\ArticleEditType;
use NAO\BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $listArticles = $em
            ->getRepository('NAOBlogBundle:Article')
            ->findAll();

        return $this->render('NAOBlogBundle:Blog:index.html.twig', array(
            'listArticles' => $listArticles,
        ));
    }

    public function viewAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        // Récupération de la liste des candidatures de l'annonce
        $listArticles = $em
            ->getRepository('NAOBlogBundle:Article')
            ->findBy(array('article' => $article));
        // Récupération des AdvertSkill de l'annonce
        $listComments = $em
            ->getRepository('NAOBlogBundle:Comment')
            ->findBy(array('article' => $article));
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'article' => $article,
            'listArticles' => $listArticles,
            'listComments' => $listComments,
        ));
    }

    public function addAction(Request $request)
    {
        $article = new Article();
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistrée.');

            return $this->redirectToRoute('nao_blog_view', array('id' => $article->getId()));
        }
        return $this->render('NAOBlogBundle:Article:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Article $article, Request $request)
    {
        $form = $this->get('form.factory')->create(ArticleEditType::class, $article);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifiée');

            return $this->redirectToRoute('nao_blog_view', array('id' => $article->getId()));
    }

    return $this->render('NAOBlogBundle:Blog:edit.html.twig', array(
        'article'=> $article,
        'form' => $form->createView(),
    ));

    }

    public function deleteAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimée.");
            return $this->redirectToRoute('nao_blog_homepage');
        }

        return $this->render('OCPlatformBundle:Article:delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }


}
