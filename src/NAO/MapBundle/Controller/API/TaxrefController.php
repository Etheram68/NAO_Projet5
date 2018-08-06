<?php

namespace NAO\MapBundle\Controller\API;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TaxrefController
 * @package NAO\MapBundle\Controller
 * @Route("/API/taxref")
 */
class TaxrefController extends Controller
{
    /**
     * Get List searching name
     * @Route("/search/name", name="taxref.search.name")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchNameOfTaxrefAction(Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $name           = $request->request->get('name');
        $result         = array();
        $autocomplete   = $em->getRepository('NAOMapBundle:Taxref')->autocompleteByCommonName($name);
        foreach ($autocomplete as $value){
            $result[] = array(
                'text'      => $value['text'] .' ('.$value['latin'].')',
            );
        }
        return new JsonResponse($result);
    }
}