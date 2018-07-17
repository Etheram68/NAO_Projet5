<?php

namespace NAO\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOMapBundle:Map:index.html.twig');
    }
}
