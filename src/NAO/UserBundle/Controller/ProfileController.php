<?php
// src/NAO/UserBundle/Controller/ProfileController.php

namespace NAO\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use NAO\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ProfileController extends BaseController
{


    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $points = $user->getPoints();

        // $user->level = $this->container->get('nao_user.level_levelCalcul')->guessLevel($points);

        $userLevel = $this->container->get('nao_user.level_levelCalcul')->guessLevel($points);


        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'userLevel' => $userLevel,
        ));
    }


    // AVEC USER ARGUMENT

    // public function showAction(User $user=null)
    // {

    //     if( $user == null ) {
    //         $user = $this->container->get('security.context')->getToken()->getUser();
    //         if (!is_object($user) || !$user instanceof UserInterface) {
    //             throw new AccessDeniedException('This user does not have access to this section.');
    //         }
    //     }

    //     $user = $this->getUser();

    //     $points = $user->getPoints();

    //     // $user->level = $this->container->get('nao_user.level_levelCalcul')->guessLevel($points);

    //     $userLevel = $this->container->get('nao_user.level_levelCalcul')->guessLevel($points);


    //     return $this->render('@FOSUser/Profile/show.html.twig'.$this->container->getParameter('fos_user.template.engine'), array(
    //         'user' => $user,
    //         'userLevel' => $userLevel,
    //     ));
    // }


    // ORIGINALE

    // public function showAction()
    // {
    //     $user = $this->getUser();
    //     if (!is_object($user) || !$user instanceof UserInterface) {
    //         throw new AccessDeniedException('This user does not have access to this section.');
    //     }

    //     return $this->render('@FOSUser/Profile/show.html.twig', array(
    //         'user' => $user,
    //     ));
    // }
}
