<?php

namespace NAO\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOUserBundle:Default:index.html.twig');
    }
}
