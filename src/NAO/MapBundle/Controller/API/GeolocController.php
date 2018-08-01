<?php

namespace NAO\MapBundle\Controller\API;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GeolocController
 * @package NAO\MapBundle\Controller
 * @Route("/API/region")
 */
class GeolocController extends Controller
{
    /**
     * Get List searching city
     *
     * @Route("/search/city", name="region.search.city")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchCityOfRegionAction(Request $request)
    {
        $em         = $this->getDoctrine()->getManager();
        $city       = $request->request->get('city');
        $result     = array();

        $autocomplete = $em->getRepository('NAOMapBundle:FranceRegion')->autocompleteByCity($city);

        foreach ($autocomplete as $value){
            $code = substr($value['code'],0,2) == '97' ? substr($value['code'],0,3) : substr($value['code'],0,2);
            $result[] = array(
                'text'    =>  $value['city'] .' '. '('.$code.')'
            );
        }
        return new JsonResponse($result);
    }

    /**
     * Get city from GPS
     *
     * @Route("/nearest/city", name="region.nearest.city")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchNearestCityFromCoordinateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $latitude   = $request->request->get('lat');
        $longitude  = $request->request->get('lng');
        $city = '';

        for ($d= 500; $d <= 50000; $d+= 500)
        {
            $region     = $em->getRepository('NAOMapBundle:FranceRegion')->getDistanceByCoordinate($latitude,$longitude, $d);
            if(!is_null($region)){
                $code = substr($region['code'],0,2) == '97' ? substr($region['code'],0,3) : substr($region['code'],0,2);
                $city   = $region['city'] .' '. '('.$code.')';
                break;
            }
        }
        return new JsonResponse(['city' => $city ]);
    }
}