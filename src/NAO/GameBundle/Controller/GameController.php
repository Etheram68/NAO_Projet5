<?php

namespace NAO\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GameController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOGameBundle:Game:index.html.twig');
    }
}
