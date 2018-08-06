<?php
// src/NAO/UserBundle/Level/LevelCalcul.php

namespace NAO\UserBundle\Level;

use Doctrine\ORM\EntityManagerInterface;
use NAO\UserBundle\Entity\User;


class LevelCalcul
{
  private $niveau00;
  private $niveau01;
  private $niveau02;
  private $niveau03;
  private $niveau04;
  private $niveau05;
  private $niveau06;
  private $niveau07;
  private $niveau08;
  private $niveau09;
  private $niveau10;

  public function __construct($niveau00, $niveau01, $niveau02, $niveau03, $niveau04, $niveau05, $niveau06, $niveau07, $niveau08, $niveau09, $niveau10)
  {
    $this->niveau00 = $niveau00;
    $this->niveau01 = $niveau01;
    $this->niveau02 = $niveau02;
    $this->niveau03 = $niveau03;
    $this->niveau04 = $niveau04;
    $this->niveau05 = $niveau05;
    $this->niveau06 = $niveau06;
    $this->niveau07 = $niveau07;
    $this->niveau08 = $niveau08;
    $this->niveau09 = $niveau09;
    $this->niveau10 = $niveau10;
  }

  public function guessLevel($points)
  { 
    $level = '';

    if ($points >= 0 && $points < 30) {
      $level = $this->niveau00;
    } elseif ($points >= 30 && $points < 60) {
      $level = $this->niveau01;
    } elseif ($points >= 60 && $points < 100) {
      $level = $this->niveau02;
    } elseif ($points >= 100 && $points < 150) {
      $level = $this->niveau03;
    } elseif ($points >= 150 && $points < 230) {
      $level = $this->niveau04;
    } elseif ($points >= 230 && $points < 330) {
      $level = $this->niveau05;
    } elseif ($points >= 330 && $points < 450) {
      $level = $this->niveau06;
    } elseif ($points >= 450 && $points < 600) {
      $level = $this->niveau07;
    } elseif ($points >= 600 && $points < 770) {
      $level = $this->niveau08;
    } elseif ($points >= 770 && $points < 1000) {
      $level = $this->niveau09;
    } elseif ($points >= 1000) {
      $level = $this->niveau10;
    }

    return $level;
  }

}
