<?php

namespace NAO\FicheBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NAO\FicheBundle\Entity\Bird;
use NAO\FicheBundle\Form\Type\FicheType;


/**
 * Class FicheController
 * @package NAO\FicheBundle\Controller
 * @Route("/fiche")
 */
class FicheController extends Controller
{
    /**
     * @Route("/", name="fiche.list")
     * @Method ({"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showFicheAction(Request $request)
    {
        return $this->render('fiche/fiche.html.twig', array(
            'bird'   => $this->container->get('app.fch')->getLastBird(50)
        ));
    }

    /**
     * @Route("/creation", name="fiche.create")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $bird = new Bird();
        $form = $this->createForm(FicheType::class, $bird);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $action = $this->container->get('app.fch')->saveObservation($bird, $form, $request);
            if($action == 'DRAFT'){
                return $this->redirectToRoute('fiche.me.draft');
            }elseif($action == 'WAITING'){
                return $this->redirectToRoute('fiche.me.waiting');
            }elseif($action == 'PUBLISHED'){
                return $this->redirectToRoute('fiche.me.validate');
            }
        }
        return $this->render('fiche/create.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/{id}", name="fiche.detail", requirements={"id": "\d+"})
     * @ParamConverter("fiche", options={"mapping": {"id": "id"}})
     * @Method({"GET"})
     */
    public function showDetailAction(Fiche $fiche)
    {
        if($fiche->getStatus() != $fiche::VALIDATED){
            throw $this->createNotFoundException('Observation need to be validate !');
        }
        $em = $this->getDoctrine()->getManager();
        $lastfiche = $em->getRepository('NAOFicheBundle:Bird')
            ->getLastFicheForBird($fiche->getTaxref()->getId(),$fiche->getId());
        return $this->render('fiche/detail.html.twig', array(
            'fiche'   => $fiche,
            'lastfiche'       => $lastfiche != [] ? $lastfiche[0] : null
        ));
    }
}