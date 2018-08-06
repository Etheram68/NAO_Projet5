<?php

namespace NAO\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use NAO\MapBundle\Validator\CityCheck;

/**
 * Observation
 *
 * @ORM\Table(name="observation")
 * @ORM\Entity(repositoryClass="NAO\MapBundle\Repository\ObservationRepository")
 */
class Observation
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
     * @var smallint
     *
     * @ORM\Column(name="status", type="smallint")
     * @Assert\Choice(choices = {Observation::WAITING,Observation::VALIDATED,Observation::REFUSED, Observation::DRAFT}, strict = true)
     */
    private $status;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validated", type="datetimetz", nullable=true)
     */
    private $validated;
    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(name="watched", type="datetimetz", nullable=true)
     */
    private $watched;
    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", length=100, nullable=true)
     * @CityCheck()
     */
    private $place;
    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=9, scale=7)
     */
    private $latitude;
    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7)
     */
    private $longitude;
    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255, nullable=true)
     */
    private $image_path;

    /**
     * @var text
     *
     * @ORM\Column(name="comments", type="text", nullable=true)
     */
    private $comments;
    /**
     * @var integer
     *
     * @ORM\Column(name="individuals", type="integer")
     */
    private $individuals;
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
     * @ORM\JoinColumn(nullable=false)
     */
    private $taxref;
    /**
     * Observation constructor.
     */
    public function __construct()
    {
        $this->image_path   = 'default-image_observation.png';
    }
    /**
     * Get id
     *
     * @return integer
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
     * @return Observation
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Set validated
     *
     * @param \DateTime $validated
     *
     * @return Observation
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
        return $this;
    }
    /**
     * Get validated
     *
     * @return \DateTime
     */
    public function getValidated()
    {
        return $this->validated;
    }
    /**
     * Set watched
     *
     * @param \DateTime $watched
     *
     * @return Observation
     */
    public function setWatched($watched)
    {
        $this->watched = $watched;
        return $this;
    }
    /**
     * Get watched
     *
     * @return \DateTime
     */
    public function getWatched()
    {
        return $this->watched;
    }
    /**
     * Get watched
     *
     * @return \DateTime
     */
    public function getWatchedString()
    {
        return !is_null($this->getWatched()) ? $this->getWatched()->format('m/d/Y') : '';
    }
    /**
     * Set place
     *
     * @param string $place
     *
     * @return Observation
     */
    public function setPlace($place)
    {
        $this->place = $place;
        return $this;
    }
    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }
    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }
    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }
    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return Observation
     */
    public function setImagePath($imagePath)
    {
        $this->image_path = $imagePath;
        return $this;
    }
    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->image_path;
    }
    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Observation
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }
    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**obs
     * Set individuals
     *
     * @param integer $individuals
     *
     * @return Observation
     */
    public function setIndividuals($individuals)
    {
        $this->individuals = $individuals;
        return $this;
    }
    /**
     * Get individuals
     *
     * @return integer
     */
    public function getIndividuals()
    {
        return $this->individuals;
    }
    /**
     * Set user
     *
     * @param \NAO\UserBundle\Entity\User $user
     *
     * @return Observation
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
     * @return Observation
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
     * @return Observation
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
     * @return Observation
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
