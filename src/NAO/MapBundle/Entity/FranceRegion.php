<?php

namespace NAO\MapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * FranceRegion
 *
 * @ORM\Table(name="france_region", indexes={@Index(name="idx_gps", columns={"latitude", "longitude"})})
 * @ORM\Entity(repositoryClass="NAO\MapBundle\Repository\FranceRegionRepository")
 */
class FranceRegion
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
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var int
     *
     * @ORM\Column(name="regionCode", type="smallint")
     */
    private $regionCode;

    /**
     * @var string
     *
     * @ORM\Column(name="regionName", type="string", length=255)
     */
    private $regionName;

    /**
     * @var int
     *
     * @ORM\Column(name="chiefTown", type="string", length=255)
     */
    private $chiefTown;

    /**
     * @var smallint
     *
     * @ORM\Column(name="county_code", type="string", length=1265)
     */
    private $countyCode;

    /**
     * @var string
     *
     * @ORM\Column(name="county", type="string", length=255)
     */
    private $county;

    /**
     * @var string
     *
     * @ORM\Column(name="prefecture", type="string", length=255)
     */
    private $prefecture;

    /**
     * @var int
     *
     * @ORM\Column(name="disctrictCode", type="smallint")
     */
    private $disctrictCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string           $franceRegion->setChiefTown($line[2]);
     *
     * @ORM\Column(name="postcode", type="string", length=255)
     */
    private $postcode;

    /**
     * @var int
     *
     * @ORM\Column(name="insee", type="integer")
     */
    private $insee;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=9, scale=7)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="decimal", precision=3, scale=2, nullable=true)
     */
    private $distance;


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
     * Set region
     *
     * @param string $region
     *
     * @return FranceRegion
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set regionCode
     *
     * @param integer $regionCode
     *
     * @return FranceRegion
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    /**
     * Get regionCode
     *
     * @return integer
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Set regionName
     *
     * @param string $regionName
     *
     * @return FranceRegion
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;

        return $this;
    }

    /**
     * Get regionName
     *
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set chiefTown
     *
     * @param string $chiefTown
     *
     * @return FranceRegion
     */
    public function setChiefTown($chiefTown)
    {
        $this->chiefTown = $chiefTown;

        return $this;
    }

    /**
     * Get chiefTown
     *
     * @return string
     */
    public function getChiefTown()
    {
        return $this->chiefTown;
    }

    /**
     * Set countyCode
     *
     * @param string $countyCode
     *
     * @return FranceRegion
     */
    public function setCountyCode($countyCode)
    {
        $this->countyCode = $countyCode;
        return $this;
    }
    /**
     * Get countyCode
     *
     * @return string
     */
    public function getCountyCode()
    {
        return $this->countyCode;
    }

    /**
     * Set county
     *
     * @param string $county
     *
     * @return FranceRegion
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set prefecture
     *
     * @param string $prefecture
     *
     * @return FranceRegion
     */
    public function setPrefecture($prefecture)
    {
        $this->prefecture = $prefecture;

        return $this;
    }

    /**
     * Get prefecture
     *
     * @return string
     */
    public function getPrefecture()
    {
        return $this->prefecture;
    }

    /**
     * Set disctrictCode
     *
     * @param integer $disctrictCode
     *
     * @return FranceRegion
     */
    public function setDisctrictCode($disctrictCode)
    {
        $this->disctrictCode = $disctrictCode;

        return $this;
    }

    /**
     * Get disctrictCode
     *
     * @return integer
     */
    public function getDisctrictCode()
    {
        return $this->disctrictCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return FranceRegion
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return FranceRegion
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set insee
     *
     * @param integer $insee
     *
     * @return FranceRegion
     */
    public function setInsee($insee)
    {
        $this->insee = $insee;

        return $this;
    }

    /**
     * Get insee
     *
     * @return integer
     */
    public function getInsee()
    {
        return $this->insee;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return FranceRegion
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
     * @return FranceRegion
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
     * Set distance
     *
     * @param string $distance
     *
     * @return FranceRegion
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return string
     */
    public function getDistance()
    {
        return $this->distance;
    }
}

