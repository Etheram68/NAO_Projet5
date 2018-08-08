<?php

namespace NAO\MapBundle\Controller\API;

use NAO\MapBundle\Entity\Observation;
use NAO\FicheBundle\Entity\Bird;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;

/**
 * Class API\ObservationController
 * @package NAO\MapBundle\Controller
 * @Route("/API/observation")
 */
class ObservationController extends Controller
{
    /**
     * @Route("/list", name="obs.list")
     * @Method({"POST"})
     */
    public function obslistAction(Request $request)
    {
        $url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $response = $this->container->get('app.obs')->getlist($url);
        $viewHandler = $this->get('fos_rest.view_handler');
        $view = View::create($response);
        $view->setFormat('json');
        return $viewHandler->handle($view);
    }

    /**
     * Add Observation
     *
     * @Route("/add", name="obs.add")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function obsaddAction(Request $request)
    {
        $response = $this->container->get('app.obs')->add($request->get('observation'));
        $viewHandler = $this->get('fos_rest.view_handler');
        $view = View::create($response);
        $view->setFormat('json');
        return $viewHandler->handle($view);
    }

    /**
     * Get a region from GPS
     *
     * @Route("/region", name="obs.region")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function regionAction(Request $request)
    {
        $latitude =$request->get('latitude');
        $longitude = $request->get('longitude');
        $response = $this->container->get('app.geoloc')->getFranceRegion($latitude,$longitude);
        $viewHandler = $this->get('fos_rest.view_handler');
        $view = View::create($response);
        $view->setFormat('json');
        return $viewHandler->handle($view);
    }

    /**
     * Get All observation from GPS
     *
     * @Route("nearest", name="obs.nearest")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function nearestAction(Request $request)
    {
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $observations = $this->container->get('app.geoloc')->getNearest($latitude,$longitude,$this->getParameter('gps_distance'));
        foreach ($observations as $observation){
            $response[] = [
                'id' => $observation->getId(),
                'validated' => $observation->getValidated(),
                'watched' => $observation->getWatched(),
                'place' => $observation->getPlace(),
                'latitude' => $observation->getLatitude(),
                'longitude' => $observation->getLongitude(),
                'imagePath' => $observation->getImagePath(),
                'comments' => $observation->getComments(),
                'individuals' => $observation->getIndividuals(),
                'observer' => $observation->getUser()->getName(),
                'naturalist' => $observation->getNaturalist()->getName(),
                'regnum' => $observation->getTaxref()->getRegnum(),
                'phylum' => $observation->getTaxref()->getPhylum(),
                'classis' => $observation->getTaxref()->getClassis(),
                'ordo' => $observation->getTaxref()->getOrdo(),
                'familia' => $observation->getTaxref()->getFamilia(),
                'validName' => $observation->getTaxref()->getValidName(),
                'commonName' => $observation->getTaxref()->getCommonName()
            ];
        }
        $viewHandler = $this->get('fos_rest.view_handler');
        $view = View::create($response);
        $view->setFormat('json');
        return $viewHandler->handle($view);
    }

    /**
     * Get Observation With filters
     *
     * @Route("/search", name="obs.search")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getObservationsForMapAction(Request $request)
    {
        // Get filters
        $specimen   = trim($request->get('bird'));
        $department = (int) $request->get('department');
        $result         = array();
        $latin_name = substr($specimen, ($p = strpos($specimen, '(')+1), strrpos($specimen, ')')-$p);
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('NAOMapBundle:Observation')->getObservationsWithFilter($latin_name, $department);
        foreach ($observations as $observation){
            $result[] = array(
                'place'     => $observation->getPlace(),
                'latitude'  => $observation->getLatitude(),
                'longitude' => $observation->getLongitude()
            );
        }
        // Generate observations list
        $html = $this->render('observation/list.html.twig', [
            'obslist' => $observations,
        ])->getContent();
        $result['html'] = $html;
        // Return message after searching
        if(empty($specimen) && $department == 0 ){
            $result['message'] = $this->get('translator')->trans('%nombre% observations ont été validées sur le site. Consultez la liste pour plus de détails', array('%nombre%' => sizeof($observations)));
        }else{
            $result['message'] = ( sizeof($observations) > 0 ) ?
                $this->get('translator')->trans('Il y a %nombre% observation(s) trouvée(s) correspondante aux critères de votre recherche. Consultez la liste pour plus de détails', array('%nombre%' => sizeof($observations))) :
                $this->get('translator')->trans('Il n\'y a pas d\'observation correspondante aux critères de votre recherche.');
        }
        return new JsonResponse($result);
    }

    /**
     * Paginate Observation list
     *
     * @Route("/paginate", name="api_obs_paginate")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('NAOMapBundle:Observation')->getMyObservations(
            $request->request->get('state'),
            $this->get('security.token_storage')->getToken()->getUser(),
            $request->request->get('page'),
            $this->getParameter('list_limit')
        );
        $html = $this->render('observation/list.html.twig', [
            'obslist' => $obs->getIterator(),
        ])->getContent();
        return new JsonResponse(['html' => $html]);
    }

    /**
     * Get Fiche With filters
     *
     * @Route("/searchs", name="bird.search")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFicheForMapAction(Request $request)
    {
        // Get filters
        $specimen   = trim($request->get('bird'));
        $result         = array();
        $latin_name = substr($specimen, ($p = strpos($specimen, '(')+1), strrpos($specimen, ')')-$p);
        $em = $this->getDoctrine()->getManager();
        $bird = $em->getRepository('NAOFicheBundle:Bird')->getBirdWithFilter($latin_name);
        // Generate observations list
        $html = $this->render('fiche/list.html.twig', [
            'birdlist' => $bird,
        ])->getContent();
        $result['html'] = $html;
        // Return message after searching
        if(empty($specimen)){
            $result['message'] = $this->get('translator')->trans('%nombre% observations ont été validées sur le site. Consultez la liste pour plus de détails', array('%nombre%' => sizeof($bird)));
        }else{
            $result['message'] = ( sizeof($bird) > 0 ) ?
                $this->get('translator')->trans('Il y a %nombre% observation(s) trouvée(s) correspondante aux critères de votre recherche. Consultez la liste pour plus de détails', array('%nombre%' => sizeof($bird))) :
                $this->get('translator')->trans('Il n\'y a pas d\'observation correspondante aux critères de votre recherche.');
        }
        return new JsonResponse($result);
    }
}