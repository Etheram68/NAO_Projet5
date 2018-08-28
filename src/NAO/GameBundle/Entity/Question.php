<?php

namespace NAO\GameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="NAO\GameBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="problem", type="string")
     *
     */
    private $problem;


    /**
     * @ORM\Column(type="string")
     */
    private $answer1;

    /**
     * @ORM\Column(type="string")
     */
    private $answer2;

    /**
     * @ORM\Column(type="string")
     */
    private $goodAnswer;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAnswer1()
    {
        return $this->answer1;
    }

    /**
     * @param mixed $answer1
     */
    public function setAnswer1($answer1)
    {
        $this->answer1 = $answer1;
    }

    /**
     * @return mixed
     */
    public function getAnswer2()
    {
        return $this->answer2;
    }

    /**
     * @param mixed $answer2
     */
    public function setAnswer2($answer2)
    {
        $this->answer2 = $answer2;
    }

    /**
     * @return mixed
     */
    public function getGoodAnswer()
    {
        return $this->goodAnswer;
    }

    /**
     * @param mixed $goodAnswer
     */
    public function setGoodAnswer($goodAnswer)
    {
        $this->goodAnswer = $goodAnswer;
    }


    /**
     * Set problem.
     *
     * @param string $problem
     *
     * @return Question
     */
    public function setProblem($problem)
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Get problem.
     *
     * @return string
     */
    public function getProblem()
    {
        return $this->problem;
    }
}
