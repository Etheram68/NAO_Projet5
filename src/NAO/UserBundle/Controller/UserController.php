<?php
// src/NAO/UserBundle/Controller/UserController.php

namespace NAO\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NAO\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * User controller.
 *
 */
class UserController extends Controller
{    
    /**
     * Montrer un utilisateur
     * @Route("/user/{username}", name="user.username")
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     * @Method({"GET"})
     *
     * @param Request $request Http request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByUserNameAction($username) {
 
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy( array('username' => $username) );
        if ( $user == null) {
            throw new NotFoundHttpException("Pseudo non valide");
        }
        $points = $user->getPoints();
        $userLevel = $this->container->get('naouser.level.levelCalcul')->guessLevel($points);

        return $this->container->get('templating')->renderResponse('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'userLevel' => $userLevel,
        ));
    }

    /**
     * Montrer un utilisateur
     * @Route("/user/{username}/edit", name="user.username.edit")
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     * @Method({"GET"})
     *
     * @param Request $request Http request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($username) {
 
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}