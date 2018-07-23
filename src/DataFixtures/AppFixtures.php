<?php
/**
 * Created by PhpStorm.
 * User: Arak
 * Date: 23/07/2018
 * Time: 17:43
 */

namespace NAO\DataFixtures;


use NAO\BlogBundle\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 articles!
        for ($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->setDate(new \DateTime('01/08/1991'));
            $article->setTitle('Encore une débilité');
            $article->setAuthor('Bob');
            $article->setContent('Et quia Mesopotamiae tractus omnes crebro inquietari sueti praetenturis et stationibus servabantur agrariis, laevorsum flexo itinere Osdroenae subsederat extimas partes, novum parumque aliquando temptatum commentum adgressus.');
            $manager->persist($article);
        }

        $manager->flush();
}
}