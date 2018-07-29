<?php

namespace NAO\BlogBundle\Controller;


use NAO\BlogBundle\Entity\Article;
use NAO\BlogBundle\Entity\Comment;
use NAO\BlogBundle\Form\ArticleEditType;
use NAO\BlogBundle\Form\ArticleType;
use NAO\BlogBundle\Form\CommentEditType;
use NAO\BlogBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BlogController extends Controller
{
    /**
     * HomePage
     * @Route("/blog", name="blog")
     * @Method({"GET"})
     *
     * @param Request $request Http request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $listArticles = $em
            ->getRepository('NAOBlogBundle:Article')
            ->findAll();

        $listComments = $em
            ->getRepository('NAOBlogBundle:Comment')
            ->findAll();

        return $this->render('blog\index.html.twig', array(
            'listArticles' => $listArticles,
            'listComments' => $listComments,

        ));
    }

    /**
     * View
     *
     * @Route("/view/{id}", name="blog.view")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        // Récupération des Commentaires de l'annonce
        $listComments = $em
            ->getRepository('NAOBlogBundle:Comment')
            ->findBy(array('article' => $article));
        return $this->render('blog\view.html.twig', array(
            'article' => $article,
            'listComments' => $listComments,
        ));
    }

    /**
     * add article
     *
     * @Route("/add", name="blog.add")
     *
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addAction(Request $request)
    {
        $article = new Article();
        $form = $this->get('form.factory')->create(ArticleType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistrée.');

            return $this->redirectToRoute('blog.view', array('id' => $article->getId()));
        }
        return $this->render('blog\add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * edit article
     *
     * @Route("/edit/{id}", name="blog.edit")
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Article $article, Request $request)
    {
        $form = $this->get('form.factory')->create(ArticleEditType::class, $article);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifiée');

            return $this->redirectToRoute('blog.view', array('id' => $article->getId()));
    }

    return $this->render('blog\edit.html.twig', array(
        'article'=> $article,
        'form' => $form->createView(),
    ));

    }

    /**
     * delete article
     *
     * @Route("/remove/{id}", name="blog.remove")
     *
     * @param Article $article Request $request Http request
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
            return $this->redirectToRoute('blog');
        }

        return $this->render('blog\delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }

    /**
     * add article
     *
     * @Route("/addcomment/{id}", name="comment.add")
     *
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addCommentAction(Request $request)
    {
        $comment = new Comment();
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');


            return $this->redirectToRoute('blog.view', array(
                'id' => $comment->getArticle()->getId(),
                'comment' => $comment->getId()
            ));
        }
        return $this->render('blog\addComment.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * edit article
     *
     * @Route("/edit/{id}", name="comment.edit")
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editCommentAction(Comment $comment, Request $request)
    {
        $form = $this->get('form.factory')->create(CommentEditType::class, $comment);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien modifié');

            return $this->redirectToRoute('blog.view', array('id' => $comment->getId()));
        }

        return $this->render('blog\edit.html.twig', array(
            'comment'=> $comment,
            'form' => $form->createView(),
        ));

    }

    /**
     * delete article
     *
     * @Route("/remove", name="comment.remove")
     *
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteCommentAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimée.");
            return $this->redirectToRoute('blog');
        }

        return $this->render('blog\delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }


}
