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


/**
 * Class BlogController
 * @package NAO\BlogBundle\Controller
 * @Route("/blog")
 */
class BlogController extends Controller
{
    /**
     * HomePage
     * @Route("/", name="index")
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
     * @Route("/blog/view/{id}",requirements={"id" = "\d+"}, name="article")
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
     * @Route("/blog/add", name="article.add")
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

            return $this->redirectToRoute('article', array('id' => $article->getId()));
        }
        return $this->render('blog\add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * edit article
     *
     * @Route("/blog/view/{id}/edit", requirements={"id" = "\d+"} , name="article.edit")
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

            return $this->redirectToRoute('article', array('id' => $article->getId()));
    }

    return $this->render('blog\edit.html.twig', array(
        'article'=> $article,
        'form' => $form->createView(),
    ));

    }

    /**
     * delete article
     *
     * @Route("/blog/view/{id}/delete", name="article.delete")
     *
     * @param Article $article Request $request Http request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();


        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            foreach ($article->getComments() as $comment){
                $em->remove($comment);
            }
            $em->remove($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimée.");
            return $this->redirectToRoute('index');
        }

        return $this->render('blog\delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }

    /**
     * add comment
     *
     * @Route("/blog/comment/{id}", name="comment.add")
     *
     * @param Comment $comment
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function addCommentAction(Request $request, Article $article)
    {
        $comment = new Comment();
        $comment->setDate(new \DateTime());
        $comment->setArticle($article);
        $form = $this->get('form.factory')->create(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');


            return $this->redirectToRoute('article', array(
                'id' => $comment->getArticle()->getId(),
                'addComment' => $comment->getId()
            ));
        }
        return $this->render('blog\addComment.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * edit article
     *
     * @Route("/blog/edit/{id}", name="comment.edit")
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

            return $this->redirectToRoute('article', array('id' => $comment->getId()));
        }

        return $this->render('blog\edit.html.twig', array(
            'comment'=> $comment,
            'form' => $form->createView(),
        ));

    }

}
