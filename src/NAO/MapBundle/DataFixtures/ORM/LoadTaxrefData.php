<?php

namespace NAO\MapBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use NAO\MapBundle\Entity\Taxref;

/**
 * Class LoadTaxref
 * @package NAO\MapBundle\DataFixtures\ORM
 */
class LoadTaxrefData extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    /**
     * Create users*
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // bin/console doctrine:fixtures:load
        $csv = fopen('./src/NAO/MapBundle/DataFixtures/ORM/TAXREF.csv', 'r');
        $first = true;
        $count = 0;
        while (!feof($csv)) {
            if ($first) {
                $first = false;
                continue;
            }
            $count++;
            $line = fgetcsv($csv, 0, ';');
            if (empty($line)) {
                continue;
            };
            $taxref = new Taxref();
            $taxref->setRegnum($line[0]);
            $taxref->setPhylum($line[1]);
            $taxref->setClassis($line[2]);
            $taxref->setOrdo($line[3]);
            $taxref->setFamilia($line[4]);
            $taxref->setScientificId($line[5]);
            $taxref->setTaxonId($line[6]);
            $taxref->setTaxonRefId($line[7]);
            $taxref->setTaxonRank($line[8]);
            $taxref->setTaxonSc($line[9]);
            $taxref->setAuthor($line[10]);
            $taxref->setFullname($line[11]);
            $taxref->setValidName($line[12]);
            $taxref->setCommonName($line[13]);
            $taxref->setCommonNameEn($line[14]);
            $taxref->setHabitat($line[15]);
            $taxref->setFrance($line[16]);
            $taxref->setGuyaneFrancaise($line[17]);
            $taxref->setMartique($line[18]);
            $taxref->setGuadeloupe($line[19]);
            $taxref->setSaintMartin($line[20]);
            $taxref->setSaintBarthelemy($line[21]);
            $taxref->setSaintPierreEtMiquelon($line[22]);
            $taxref->setMayotte($line[23]);
            $taxref->setIlesEparses($line[24]);
            $taxref->setReunion($line[25]);
            $taxref->setSaintPaul($line[26]);
            $taxref->setTerreAdelie($line[27]);
            $taxref->setIlesSubAntartique($line[28]);
            $taxref->setNouvelleCaledonie($line[29]);
            $taxref->setWallisEtFutuna($line[30]);
            $taxref->setPolynesieFrancaise($line[31]);
            $taxref->setClipperton($line[32]);
            if ($taxref->getScientificId() == 416687) {
                $this->addReference('416687', $taxref);
            }
            $manager->persist($taxref);
        }
        fclose($csv);
        $manager->flush();
    }
}