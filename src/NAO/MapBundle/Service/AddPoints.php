<?php
// src/NAO/MapBundle/Service/AddPoints.php

namespace NAO\MapBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use NAO\UserBundle\Entity\User;


class AddPoints
{
  private $user;

  public function __construct($user)
  {
    $this->user = $user;
  }

  public function addPointsToUser($user)
  { 
    $points = 10 + $user->getPoints();   
    return $points;
  }

}
