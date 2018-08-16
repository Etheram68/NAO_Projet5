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
        $userManager = $this->get('fos_user.user_manager');
        $bestUsers = $userManager->findUsers(array(), array(
        	'points' => 'desc'
        ));
		foreach ($bestUsers as $user) {
		    $points = $user->getPoints();
		    $level = $this->container->get('naouser.level.levelCalcul')->guessLevel($points);
		    $user->setLevel($level);
		}        

        return $this->render('game\index.html.twig', array(
            'bestUsers' => $bestUsers,
        ));
    }
}
