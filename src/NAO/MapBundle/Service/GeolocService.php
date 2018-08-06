<?php
namespace NAO\MapBundle\Service;
use NAO\MapBundle\Entity\Observation;
use Doctrine\ORM\EntityManager;
use NAO\MapBundle\Service\GPS;
/**
 * Class GeolocService
 *
 * @package NAO\MapBundle\Service
 */
class GeolocService
{
    private $em;
    private $gps;

    /**
     * GeolocService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, GPSService $gps)
    {
        $this->em = $em;
        $this->gps = $gps;
    }
    /**
     * Get the most near city
     *
     * get near region
     *
     * @return mixed
     */
    public function getFranceRegion($latitude, $longitude){
        $distance = 10000000;
        $region_id = 0;
        for($i = 1 ; $i < 40000 ; $i += 500){
            $regions = $this->em->getRepository('NAOMapBundle:FranceRegion')->getAll($i, 500);
            if(!$regions){
                break;
            }
            foreach ($regions as $region) {
                $d = $this->gps->getDistance($region->getLatitude(), $region->getLongitude(), $latitude, $longitude);
                if ($d < $distance) {
                    $distance = $d;
                    $region_id = $region->getId();
                    if($distance == 0){
                        break;
                    }
                }
            }
            $this->em->clear();
        }
        $region = $this->em->getRepository('NAOMapBundle:FranceRegion')->findOneById($region_id);
        $region->setDistance($distance);
        return $region;
    }
    /**
     * Get all observation rouding a GPS position
     *
     * @param $latitude
     * @param $longitude
     * @param $distance
     * @return array
     */
    public function getNearest($latitude, $longitude, $distance)
    {
        $observations = $this->em->getRepository('NAOMapBundle:Observation')->findBy([
                'status' => Observation::VALIDATED
            ]
        );
        $result = [];
        foreach($observations as $observation){
            $d = $this->gps->getDistance($observation->getLatitude(), $observation->getLongitude(), $latitude, $longitude);
            if($d <= $distance){
                $result[] = $observation;
            }
        }
        return $result;
    }
}