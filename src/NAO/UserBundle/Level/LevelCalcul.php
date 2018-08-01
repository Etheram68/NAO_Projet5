<?php
// src/NAO/UserBundle/Level/LevelCalcul.php

namespace NAO\UserBundle\Level;

use Doctrine\ORM\EntityManagerInterface;
use NAO\UserBundle\Entity\User;


class LevelCalcul
{
  // private $niveau00;
  // private $niveau01;
  // private $niveau02;
  // private $niveau03;
  // private $niveau04;

  // public function __construct($niveau00, $niveau01, $niveau02, $niveau03, $niveau04)
  // {
  //   $this->niveau00 = $niveau00;
  //   $this->niveau01 = $niveau01;
  //   $this->niveau02 = $niveau02;
  //   $this->niveau03 = $niveau03;
  //   $this->niveau04 = $niveau04;
  // }


  public function guessLevel($points)
  { 
    $level = '';
    $niveau01 = 'Noob';

    if ($points >= 40 && $points < 60) {
      $level = $this->niveau01;
    }

    return $level;
  }


  // public function guessLevel($points)
  // { 
  //   $level = '';

  //   if ($points >= 0 && $points < 30) {
  //     $level = $this->niveau00;
  //   } elseif ($points >= 30 && $points < 60) {
  //     $level = $this->niveau01;
  //   } elseif ($points >= 60 && $points < 100) {
  //     $level = $this->niveau02;
  //   } elseif ($points >= 100 && $points < 150) {
  //     $level = $this->niveau03;
  //   } elseif ($points >= 150 && $points < 230) {
  //     $level = $this->niveau04;
  //   }

  //   return $level;
  // }


}
