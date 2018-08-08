<?php

namespace NAO\FicheBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\FicheBundle\Entity\Bird;
use NAO\FicheBundle\Form\Type\BirdType;


/**
 * Class BirdController
 * @package NAO\FicheBundle\Controller
 * @Route("/bird")
 */
class BirdController extends Controller
{
    /**
     * @Route("/", name="bird.list")
     * @Method ({"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showBirdAction(Request $request)
    {
        return $this->render('fiche/fiche.html.twig', array(
            'bird'   => $this->container->get('app.bird')->getLastBird(50)
        ));
    }

    /**
     * @Route("/creation", name="bird.create")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $bird = new Bird();
        $form = $this->createForm(BirdType::class, $bird);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $action = $this->container->get('app.fch')->saveObservation($bird, $form, $request);
            if($action == 'DRAFT'){
                return $this->redirectToRoute('bird.me.draft');
            }elseif($action == 'WAITING'){
                return $this->redirectToRoute('bird.me.waiting');
            }elseif($action == 'PUBLISHED'){
                return $this->redirectToRoute('bird.me.validate');
            }
        }
        return $this->render('fiche/create.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/{id}", name="bird.detail", requirements={"id": "\d+"})
     * @ParamConverter("bird", options={"mapping": {"id": "id"}})
     * @Method({"GET"})
     */
    public function showDetailAction(Bird $bird)
    {
        if($bird->getStatus() != $bird::VALIDATED){
            throw $this->createNotFoundException('Observation need to be validate !');
        }
        $em = $this->getDoctrine()->getManager();
        $lastbird = $em->getRepository('NAOFicheBundle:Bird')
            ->getLastBirdForBird($bird->getTaxref()->getId(),$bird->getId());
        return $this->render('fiche/detail.html.twig', array(
            'bird'   => $bird,
            'lastbird'       => $lastbird != [] ? $lastbird[0] : null
        ));
    }
}