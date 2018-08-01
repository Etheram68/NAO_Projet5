<?php
// src/NAO/UserBundle/Controller/UserController.php

namespace NAO\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NAO\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * User controller.
 *
 */
class UserController extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

    
    // /**
    //  * ListUsers
    //  * @Route("/users", name="usersList")
    //  * @Method({"GET"})
    //  *
    //  * @param Request $request Http request
    //  *
    //  * @return \Symfony\Component\HttpFoundation\Response
    //  */
    // public function indexAction()
    // {
    //     $userManager = $this->get('fos_user.user_manager');
    //     $users = $userManager->findUsers();
    //     return $this->render('user/index.html.twig', array(
    //         'users' => $users,
    //     ));
    // }

}