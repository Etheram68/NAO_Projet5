<?php

namespace NAO\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use NAO\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;


class ProfilChangeListener implements EventSubscriberInterface 
{
    private $router;

    public function __construct(UrlGeneratorInterface $router) {
        $this->router = $router;
    }

    public static function getSubscribedEvents() {

        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onProfilChangeSuccess',
        ];
    }

    public function onProfilChangeSuccess(FormEvent $event, $username) {

        $url = $this->router->generate('homepage');
        $event->setResponse(new RedirectResponse($url));
    }
}