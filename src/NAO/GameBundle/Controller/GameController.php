<?php

namespace NAO\GameBundle\Controller;

use NAO\GameBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class GameController extends Controller
{
    /**
     * HomePage
     * @Route("/", name="game")
     * @Method({"GET"})
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('game/index.html.twig');
    }


    public function questionAction(Request $request)
    {

        $listQuestions = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('NAOGameBundle:Question')
            ->MyfindAll()
            ;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $answers = $_POST|''




            return $this->render('game/result.html.twig');
        }

        return $this->render('game/quiz.html.twig', array(
            'listQuestions' => $listQuestions,
        ));

    }

    public function resultAction()
    {
        $answers = $form{''}
    }


}
