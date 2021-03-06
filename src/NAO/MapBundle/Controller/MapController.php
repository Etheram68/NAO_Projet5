<?php

namespace NAO\MapBundle\Controller;

use NAO\MapBundle\Entity\Observation;
use NAO\MapBundle\Form\Type\ObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class ObservationController
 * @package NAO\MapBundle\Controller
 * @Route("/observation")
 */
class MapController extends Controller
{
    /**
     * @Route ("/", name="observation.map")
     * @Method ({"GET"})
     */
    public function showMapAction(Request $request)
    {
        return $this->render('observation/map.html.twig');
    }

    /**
     * @Route("/creation", name="observation.create")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $action = $this->container->get('app.obs')->saveObservation($observation, $form, $request);
            if($action == 'DRAFT'){
                return $this->redirectToRoute('observation.me.draft');
            }elseif($action == 'WAITING'){
                return $this->redirectToRoute('observation.me.waiting');
            }elseif($action == 'PUBLISHED'){
                return $this->redirectToRoute('observation.me.validate');
            }
        }
        return $this->render('observation/create.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/vos-observations/brouillon/edition/{id}", name="observation.me.draft.edit")
     * @ParamConverter("obs", options={"mapping": {"id": "id"}})
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET", "POST"})
     */
    public function editDraftAction(Observation $obs, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($obs->getStatus() != $obs::DRAFT || $obs->getUser() != $user){
            throw $this->createNotFoundException('you cannot access of this page !');
        }
        $form = $this->createForm(ObservationType::class, $obs);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $action = $this->container->get('app.obs')->saveObservation($obs, $form, $request);
            if($action == 'DRAFT'){
                return $this->redirectToRoute('observation.me.draft');
            }elseif($action == 'WAITING'){
                return $this->redirectToRoute('observation.me.waiting');
            }elseif($action == 'PUBLISHED'){
                return $this->redirectToRoute('observation.me.validate');
            }
        }
        return $this->render('observation/create.html.twig', array(
            'form'      => $form->createView()
        ));
    }

    /**
     * @Route("/{id}", name="observation.detail", requirements={"id": "\d+"})
     * @ParamConverter("observation", options={"mapping": {"id": "id"}})
     * @Method({"GET"})
     */
    public function showDetailAction(Observation $observation)
    {
        if($observation->getStatus() != $observation::VALIDATED){
            throw $this->createNotFoundException('Observation need to be validate !');
        }
        $em = $this->getDoctrine()->getManager();
        $lastObservation = $em->getRepository('NAOMapBundle:Observation')
            ->getLastObservationForBird($observation->getTaxref()->getId(),$observation->getId());
        return $this->render('observation/detail.html.twig', array(
            'observation'   => $observation,
            'lastobs'       => $lastObservation != [] ? $lastObservation[0] : null
        ));
    }

    /**
     * @Route("/vos-observations/brouillon", name="observation.me.draft")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET"})
     */
    public function showDraftAction(Request $request, $page = 1)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('NAOMapBundle:Observation')->getMyDraftObservations($user, $page,$this->getParameter('list_limit'));
        return $this->render('observation/done/draft.html.twig', [
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            'paginate' => $this->container->get('app.obs')->getPagination($obs,$page),
            'obslist' => $obs->getIterator()
        ]);
    }

    /**
     * @Route("/vos-observations/valide", name="observation.me.validate")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET"})
     */
    public function showValidateAction(Request $request, $page = 1)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('NAOMapBundle:Observation')->getMyValidateObservations($user, $page,$this->getParameter('list_limit'));
        return $this->render('observation/done/validate.html.twig', [
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            'paginate' => $this->container->get('app.obs')->getPagination($obs,$page),
            'obslist' => $obs->getIterator()
        ]);
    }
    /**
     * @Route("/vos-observations/en-attente", name="observation.me.waiting")
     * @Security("is_granted('ROLE_USER')")
     * @Method({"GET"})
     */
    public function showWaitingAction(Request $request, $page = 1)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('NAOMapBundle:Observation')->getMyWaitingObservations($user, $page,$this->getParameter('list_limit'));
        return $this->render('observation/done/waiting.html.twig', [
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
            'paginate' => $this->container->get('app.obs')->getPagination($obs,$page),
            'obslist' => $obs->getIterator()
        ]);
    }
}
