<?php
namespace NAO\MapBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity(repositoryClass="NAO\MapBundle\Repository\PictureRepository")
 */
class Picture
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="NAO\MapBundle\Entity\Observation")
     */
    private $observation;

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
     * Set url.
     *
     * @param string $url
     *
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        return $this;
    }
    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set observation
     *
     * @param \NAO\MapBundle\Entity\Observation $observation
     *
     * @return Picture
     */
    public function setObservation(\NAO\MapBundle\Entity\Observation $observation = null)
    {
        $this->observation = $observation;
        return $this;
    }

    /**
     * Get observation
     *
     * @return \NAO\MapBundle\Entity\Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

}

