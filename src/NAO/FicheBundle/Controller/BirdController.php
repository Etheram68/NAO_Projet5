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
            $action = $this->container->get('app.bird')->saveBird($bird, $form, $request);
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
            throw $this->createNotFoundException('Fiche need to be validate !');
        }
        $em = $this->getDoctrine()->getManager();
        $lastbird = $em->getRepository('NAOFicheBundle:Bird')
            ->getLastBirdForBird($bird->getTaxref()->getId(),$bird->getId());
        return $this->render('fiche/detail.html.twig', array(
            'bird'   => $bird,
            'lastbird'       => $lastbird != [] ? $lastbird[0] : null
        ));
    }

    /**
     * @Route("/vos-fiche/en-attente", name="bird.me.waiting")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET"})
     */
    public function showWaitingAction(Request $request, $page = 1)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $bird = $em->getRepository('NAOFicheBundle:Bird')->getMyWaitingBird($user, $page,$this->getParameter('list_limit'));
        return $this->render('fiche/done/waiting.html.twig', [
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            'paginate' => $this->container->get('app.bird')->getPagination($bird,$page),
            'birdlist' => $bird->getIterator()
        ]);
    }

    /**
     * @Route("/vos-fiche/brouillon", name="bird.me.draft")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET"})
     */
    public function showDraftAction(Request $request, $page = 1)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('NAOFicheBundle:Bird')->getMyDraftBird($user, $page,$this->getParameter('list_limit'));
        return $this->render('fiche/done/draft.html.twig', [
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            'paginate' => $this->container->get('app.obs')->getPagination($obs,$page),
            'birdlist' => $obs->getIterator()
        ]);
    }

    /**
     * @Route("/vos-fiche/brouillon/edition/{id}", name="bird.me.draft.edit")
     * @ParamConverter("obs", options={"mapping": {"id": "id"}})
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editDraftAction(Bird $bird, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($bird->getStatus() != $bird::DRAFT || $bird->getUser() != $user){
            throw $this->createNotFoundException('you cannot access of this page !');
        }
        $form = $this->createForm(BirdType::class, $bird);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $action = $this->container->get('app.bird')->saveBird($bird, $form, $request);
            if($action == 'DRAFT'){
                return $this->redirectToRoute('bird.me.draft');
            }elseif($action == 'WAITING'){
                return $this->redirectToRoute('bird.me.waiting');
            }elseif($action == 'PUBLISHED'){
                return $this->redirectToRoute('bird.me.validate');
            }
        }
        return $this->render('Fiche/create.html.twig', array(
            'form'      => $form->createView()
        ));
    }
}