<?php

namespace NAO\FicheBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity(repositoryClass="NAO\FicheBundle\Repository\BirdRepository")
 * @UniqueEntity("taxref")
 */
class Bird
{
    const WAITING = 0;
    const VALIDATED = 1;
    const REFUSED = 2;
    const DRAFT = 4;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     * @Assert\Choice(choices = {Bird::WAITING,Bird::VALIDATED,Bird::REFUSED, Bird::DRAFT}, strict = true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255, nullable=true)
     */
    private $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="string", length=255, nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="Color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="feature", type="string", length=255, nullable=true)
     */
    private $feature;

    /**
     * @ORM\ManyToOne(targetEntity="NAO\UserBundle\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="NAO\UserBundle\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $naturalist;

    /**
     * @ORM\ManyToOne(targetEntity="NAO\MapBundle\Entity\Taxref", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false, unique=true)
     */
    private $taxref;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->image_path   = 'default-image_observation.png';
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
     * Set status
     *
     * @param integer $status
     *
     * @return Bird
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return Bird
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set size
     *
     * @param string $size
     *
     * @return Bird
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set weight
     *
     * @param string $weight
     *
     * @return Bird
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Bird
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set feature
     *
     * @param string $feature
     *
     * @return Bird
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * Get feature
     *
     * @return string
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Set user
     *
     * @param \NAO\UserBundle\Entity\User $user
     *
     * @return Bird
     */
    public function setUser(\NAO\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \NAO\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set naturalist
     *
     * @param \NAO\UserBundle\Entity\User $naturalist
     *
     * @return Bird
     */
    public function setNaturalist(\NAO\UserBundle\Entity\User $naturalist)
    {
        $this->naturalist = $naturalist;
        return $this;
    }

    /**
     * Get naturalist
     *
     * @return \NAO\UserBundle\Entity\User
     */
    public function getNaturalist()
    {
        return $this->naturalist;
    }

    /**
     * Set taxref
     *
     * @param \NAO\MapBundle\Entity\Taxref $taxref
     *
     * @return Bird
     */
    public function setTaxref(\NAO\MapBundle\Entity\Taxref $taxref)
    {
        $this->taxref = $taxref;
        return $this;
    }

    /**
     * Get taxref
     *
     * @return \NAO\MapBundle\Entity\Taxref
     */
    public function getTaxref()
    {
        return $this->taxref;
    }

    public function getStatusString(){
        return self::statusToString($this->status);
    }

    public static function statusToString($status){
        switch ($status){
            case self::VALIDATED:
                return 'Validée';
            case self::WAITING:
                return 'En attente';
            case self::REFUSED:
                return 'Refusée';
            default:
                return 'Erreur';
        }
    }

    /**
     * Set validation
     *
     * @param boolean $validation
     *
     * @return Bird
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;

        return $this;
    }

    /**
     * Get validation
     *
     * @return boolean
     */
    public function getValidation()
    {
        return $this->validation;
    }
}

