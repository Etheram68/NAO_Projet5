<?php

namespace NAO\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="NAO\GameBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rightOrFalse", type="boolean")
     */
    private $rightOrFalse;

    /**
     * @ORM\ManyToOne(targetEntity="NAO\GameBundle\Entity\Question", inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;




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
     * Set content.
     *
     * @param string $content
     *
     * @return Answer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set question.
     *
     * @param \NAO\GameBundle\Entity\Question|null $question
     *
     * @return Answer
     */
    public function setQuestion(\NAO\GameBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question.
     *
     * @return \NAO\GameBundle\Entity\Question|null
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set rightOrFalse.
     *
     * @param bool $rightOrFalse
     *
     * @return Answer
     */
    public function setRightOrFalse($rightOrFalse)
    {
        $this->rightOrFalse = $rightOrFalse;

        return $this;
    }

    /**
     * Get rightOrFalse.
     *
     * @return bool
     */
    public function getRightOrFalse()
    {
        return $this->rightOrFalse;
    }
}
