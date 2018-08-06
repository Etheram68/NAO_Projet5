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
use NAO\BlogBundle\Entity\Comment;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('Les oiseaux c\'est la vie.');
        $article1->setDate(new \DateTime());
        $article1->setAuthor('Alexandre');
        $article1->setContent("bla bla bla");


        $comment1 = new Comment();
        $comment1->setAuthor('Marine');
        $comment1->setDate(new \DateTime());
        $comment1->setContent("trop raison.");


        $comment2 = new Comment();
        $comment2->setAuthor('Pierre');
        $comment2->setDate(new \DateTime());
        $comment2->setContent("o lala");


        $comment1->setArticle($article1);
        $comment2->setArticle($article1);

        $article2 = new Article();
        $article2->setTitle('Les oiseaux c\'est la vie.');
        $article2->setDate(new \DateTime());
        $article2->setAuthor('Alexandre');
        $article2->setContent("bla bla bla");


        $comment3 = new Comment();
        $comment3->setAuthor('Marine');
        $comment3->setDate(new \DateTime());
        $comment3->setContent("trop raison.");


        $comment4 = new Comment();
        $comment4->setAuthor('Pierre');
        $comment4->setDate(new \DateTime());
        $comment4->setContent("Je suis très motivé.");

        $comment3->setArticle($article2);
        $comment4->setArticle($article2);

            $manager->persist($article1);
            $manager->persist($article2);
            $manager->persist($comment1);
            $manager->persist($comment2);
            $manager->persist($comment3);
            $manager->persist($comment4);



        $manager->flush();
}
}