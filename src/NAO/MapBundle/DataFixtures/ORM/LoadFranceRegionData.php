<?php

namespace NAO\MapBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use NAO\MapBundle\Entity\FranceRegion;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class LoadFranceRegion
 * @package NAO\MapBundle\DataFixtures\ORM
 */
class LoadFranceRegionData extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    /**
     * Create users*
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // bin/console doctrine:fixtures:load
        $csv = fopen('./src/NAO/MapBundle/DataFixtures/ORM/FranceRegion.csv', 'r');
        $first = true;
        $count = 0;
        while (!feof($csv)) {
            if ($first) {
                $first = false;
                continue;
            }
            $line = fgetcsv($csv, 0, ';');
            if (empty($line)) {
                continue;
            };
            $franceRegion = new FranceRegion();
            $franceRegion->setRegion($line[0]);
            $franceRegion->setRegionCode($line[1]);
            $franceRegion->setRegionName($line[2]);
            $franceRegion->setChiefTown($line[3]);
            $franceRegion->setCountyCode($line[4]);
            $franceRegion->setCounty($line[5]);
            $franceRegion->setPrefecture($line[6]);
            $franceRegion->setDisctrictCode($line[7]);
            $franceRegion->setCity($line[8]);
            $franceRegion->setPostcode($line[9]);
            $franceRegion->setInsee($line[10]);
            $franceRegion->setLatitude($line[11]);
            $franceRegion->setLongitude($line[12]);
            if(isset($line[13]) && !empty($line[13])){
                $franceRegion->setDistance($line[13]);
            } else {
                $franceRegion->setDistance(0);
            }
            $manager->persist($franceRegion);
        }
        $manager->flush();
        fclose($csv);
    }
}