<?php

namespace NAO\MapBundle\Controller;

use NAO\MapBundle\Entity\Observation;
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
}
