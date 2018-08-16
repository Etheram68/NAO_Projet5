<?php

namespace FOS\UserBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Request;


class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                // ****************************************************
                //  * Add new functionality (e.g. log the registration) *
                //  ****************************************************
                $this->container->get('logger')->info(
                    sprintf("New user registration: %s", $user)
                );

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'user' => $user,
            'targetUrl' => $this->getTargetUrlFromSession($request->getSession()),
        ));
    }
    

    /* ORIGINAL */

    /**
     * @param Request $request
     *
     * @return Response
     */
    // public function registerAction(Request $request)
    // {
    //     $user = $this->userManager->createUser();
    //     $user->setEnabled(true);

    //     $event = new GetResponseUserEvent($user, $request);
    //     $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

    //     if (null !== $event->getResponse()) {
    //         return $event->getResponse();
    //     }

    //     $form = $this->formFactory->createForm();
    //     $form->setData($user);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted()) {
    //         if ($form->isValid()) {
    //             $event = new FormEvent($form, $request);
    //             $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

    //             $this->userManager->updateUser($user);

    //             if (null === $response = $event->getResponse()) {
    //                 $url = $this->generateUrl('fos_user_registration_confirmed');
    //                 $response = new RedirectResponse($url);
    //             }

    //             $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

    //             return $response;
    //         }

    //         $event = new FormEvent($form, $request);
    //         $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

    //         if (null !== $response = $event->getResponse()) {
    //             return $response;
    //         }
    //     }

    //     return $this->render('@FOSUser/Registration/register.html.twig', array(
    //         'form' => $form->createView(),
    //     ));
    // }

}
