<?php

namespace NAO\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOGameBundle:Default:index.html.twig');
    }
}
