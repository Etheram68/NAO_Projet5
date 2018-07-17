<?php

namespace NAO\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bird
 *
 * @ORM\Table(name="bird")
 * @ORM\Entity(repositoryClass="NAO\MapBundle\Repository\BirdRepository")
 */
class Bird
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="latinName", type="string", length=255)
     */
    private $latinName;

    /**
     * @var string
     *
     * @ORM\Column(name="familly", type="string", length=255)
     */
    private $familly;

    /**
     * @var string
     *
     * @ORM\Column(name="featherColor", type="string", length=255)
     */
    private $featherColor;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="beakShape", type="string", length=255)
     */
    private $beakShape;

    /**
     * @var string
     *
     * @ORM\Column(name="pawColor", type="string", length=255)
     */
    private $pawColor;

    /**
     * @var string
     *
     * @ORM\Column(name="behavior", type="string", length=255)
     */
    private $behavior;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="watchers", type="integer")
     */
    private $watchers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editDate", type="datetime")
     */
    private $editDate;


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
     * Set name.
     *
     * @param string $name
     *
     * @return Bird
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set latinName.
     *
     * @param string $latinName
     *
     * @return Bird
     */
    public function setLatinName($latinName)
    {
        $this->latinName = $latinName;

        return $this;
    }

    /**
     * Get latinName.
     *
     * @return string
     */
    public function getLatinName()
    {
        return $this->latinName;
    }

    /**
     * Set familly.
     *
     * @param string $familly
     *
     * @return Bird
     */
    public function setFamilly($familly)
    {
        $this->familly = $familly;

        return $this;
    }

    /**
     * Get familly.
     *
     * @return string
     */
    public function getFamilly()
    {
        return $this->familly;
    }

    /**
     * Set featherColor.
     *
     * @param string $featherColor
     *
     * @return Bird
     */
    public function setFeatherColor($featherColor)
    {
        $this->featherColor = $featherColor;

        return $this;
    }

    /**
     * Get featherColor.
     *
     * @return string
     */
    public function getFeatherColor()
    {
        return $this->featherColor;
    }

    /**
     * Set size.
     *
     * @param int $size
     *
     * @return Bird
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set beakShape.
     *
     * @param string $beakShape
     *
     * @return Bird
     */
    public function setBeakShape($beakShape)
    {
        $this->beakShape = $beakShape;

        return $this;
    }

    /**
     * Get beakShape.
     *
     * @return string
     */
    public function getBeakShape()
    {
        return $this->beakShape;
    }

    /**
     * Set pawColor.
     *
     * @param string $pawColor
     *
     * @return Bird
     */
    public function setPawColor($pawColor)
    {
        $this->pawColor = $pawColor;

        return $this;
    }

    /**
     * Get pawColor.
     *
     * @return string
     */
    public function getPawColor()
    {
        return $this->pawColor;
    }

    /**
     * Set behavior.
     *
     * @param string $behavior
     *
     * @return Bird
     */
    public function setBehavior($behavior)
    {
        $this->behavior = $behavior;

        return $this;
    }

    /**
     * Get behavior.
     *
     * @return string
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Bird
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set watchers.
     *
     * @param int $watchers
     *
     * @return Bird
     */
    public function setWatchers($watchers)
    {
        $this->watchers = $watchers;

        return $this;
    }

    /**
     * Get watchers.
     *
     * @return int
     */
    public function getWatchers()
    {
        return $this->watchers;
    }

    /**
     * Set editDate.
     *
     * @param \DateTime $editDate
     *
     * @return Bird
     */
    public function setEditDate($editDate)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Get editDate.
     *
     * @return \DateTime
     */
    public function getEditDate()
    {
        return $this->editDate;
    }
}
