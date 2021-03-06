<?php

namespace NAO\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="NAO\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text", nullable=true)
     */
    private $presentation;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean", nullable=true)
     */
    private $newsletter;

    /**
     * @var bool
     *
     * @ORM\Column(name="rgpd", type="boolean")
     */
    private $rgpd;

    /**
     * @var int
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="text", nullable=true)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="NAO\MapBundle\Entity\Observation", mappedBy="user", cascade={"persist", "remove"} )
     * @Assert\Valid() 
     */
    private $observations;

    /**
     * @ORM\OneToMany(targetEntity="NAO\BlogBundle\Entity\Comment", mappedBy="user", cascade={"persist", "remove"} )
     * @Assert\Valid() 
     */
    private $comments;


    public function __construct()
    {
        parent::__construct();
        $this->observations = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return User
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return User
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set newsletter
     *
     * @param boolean $newsletter
     *
     * @return User
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set rgpd
     *
     * @param boolean $rgpd
     *
     * @return User
     */
    public function setRgpd($rgpd)
    {
        $this->rgpd = $rgpd;

        return $this;
    }

    /**
     * Get rgpd
     *
     * @return bool
     */
    public function getRgpd()
    {
        return $this->rgpd;
    }

    /**
     * Set points
     *
     * @param integer $points
     *
     * @return User
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    public function getRole()
    {
        return $this->roles;
    }

    /**
     * Add observation
     *
     * @param \NAO\MapBundle\Entity\Observation $observation
     *
     */
    public function addObservation(\NAO\MapBundle\Entity\Observation $observation)
    {        
        if ($this->observations->contains($observation)) {
            return;
        }
        $this->observations[] = $observation;
        $observation->setObservation($this);
        return $this;
    }

    /**
     * Remove observation
     *
     * @param \NAO\MapBundle\Entity\Observation $observation
     */
    public function removeObservation(\NAO\MapBundle\Entity\Observation $observation)
    {
        $this->observations->removeElement($observation);
        $observation->setObservation(null);
    }

    /**
     * Get observations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Add comment
     *
     * @param \NAO\BlogBundle\Entity\Comment $comment
     *
     */
    public function addComment(\NAO\BlogBundle\Entity\Comment $comment)
    {        
        if ($this->comments->contains($comment)) {
            return;
        }
        $this->comments[] = $comment;
        $comment->setComment($this);
        return $this;
    }

    /**
     * Remove comment
     *
     * @param \NAO\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\NAO\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
        $comment->setComment(null);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }


    /**
     * Set level
     *
     * @param string $level
     *
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}
