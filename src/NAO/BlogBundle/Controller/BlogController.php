<?php

namespace NAO\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('NAOBlogBundle:Blog:index.html.twig');
    }
}
