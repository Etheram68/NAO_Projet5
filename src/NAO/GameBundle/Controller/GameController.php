<?php

namespace NAO\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use NAO\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GameController
 * @package NAO\GameBundle\Controller
 */
class GameController extends Controller
{
	/**
	 * Game
	 * @Route("/game", name="game")
     * @Method({"GET"})
     *
     * @param Request $request Http request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
    	/* HALL OF FAME */
		$repository = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('NAOUserBundle:User')
		;
		$bestUsers = $repository->findBy(
		  array(),
		  array('points' => 'desc'),
		  50,
		  0
		);
		foreach ($bestUsers as $user) {
		    $points = $user->getPoints();
	        if ($points == null) {
	            $user->setPoints(0);
	            $points = $user->getPoints();
	        }
		    $level = $this->container->get('naouser.level.levelCalcul')->guessLevel($points);
		    $user->setLevel($level);
		}        

        return $this->render('game\index.html.twig', array(
            'bestUsers' => $bestUsers,
        ));
    }
}
