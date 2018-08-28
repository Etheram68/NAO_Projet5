<?php
/**
 * Created by PhpStorm.
 * User: Arak
 * Date: 08/08/2018
 * Time: 12:54
 */

namespace NAO\GameBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use NAO\GameBundle\Entity\Answer;
use NAO\GameBundle\Entity\Question;

class LoadQuizzFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setProblem('Question'.$i);
            $question->setAnswer1('Réponse1'.$i);
            $question->setAnswer2('Réponse2'.$i);
            $question->setGoodAnswer('goodAnswer'.$i);
            $manager->persist($question);
        }


        $manager->flush();
    }
}