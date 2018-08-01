<?php
namespace NAO\MapBundle\Twig\Extension;
class GpsDMSExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('gps_dms', array($this, 'dmsFilter')),
        );
    }
    public function dmsFilter($number)
    {
        $vars = explode(".",$number);
        $deg = $vars[0];
        $tempma = "0.".$vars[1];
        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        // Second is $tempma - ($min*60);
        $coordinate = $deg.'°'.$min.'\'';
        return $coordinate;
    }
}