<?php

namespace NAO\MapBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOMapBundle:Default:index.html.twig');
    }
}
