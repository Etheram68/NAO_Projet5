<?php

namespace NAO\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AppBundleController
 *
 * @package NAO\CoreBundle\Controller
 */
class CoreController extends Controller
{
	/**
     * HomePage
     * @Route("/", name="homepage")
     * @Method({"GET"})
     *
     * @param Request $request Http request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('homepage\index.html.twig');
    }
}
