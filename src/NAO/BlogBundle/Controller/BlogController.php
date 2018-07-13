<?php

namespace NAO\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOBlogBundle:Default:index.html.twig');
    }
}
