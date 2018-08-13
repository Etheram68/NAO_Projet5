<?php

namespace NAO\CoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use NAO\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends BaseAdminController
{
  public function updateObservationEntity($entity)
  {
    $observationStatus = $entity->getStatus();
    $user = $entity->getUser();

    /* Si l'observation est validée */
    if ($observationStatus == 1) {
      /* Appel au service */
      $points = $this->container->get('nao.obs.addPoints')->addPointsToUser($user);
      /* Update des points (+10pts) du user */
      $userManager = $this->get('fos_user.user_manager');
      $user->setPoints($points);
      $userManager->updateUser($user);
      parent::updateEntity($entity);
      $this->em->flush();
    }
    else {
      parent::updateEntity($entity);
      $this->em->flush();
    }
  }
}