<?php
namespace NAO\MapBundle\Service;
/**
 * Class GPSService
 *
 * @package NAO\MapBundle\Service
 */
class GPSService
{
    public function getDistance($lt1, $lg1, $lt2, $lg2)
    {
        $theta = $lg1 - $lg2;
        $dist = sin(deg2rad($lt1)) * sin(deg2rad($lt2)) +  cos(deg2rad($lt1)) * cos(deg2rad($lt2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
    }
}