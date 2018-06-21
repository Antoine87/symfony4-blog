<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var \Cocur\Slugify\Slugify
     */
    private $slugify;


    public function __construct()
    {
        $this->faker = Factory::create();
        $this->slugify = Slugify::create();
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadPosts($manager);
    }

    private function loadPosts(ObjectManager $manager): void
    {
        foreach ($this->getPostData() as [
            $title, $slug, $summary, $content, $image, $publishedAt, $author, $createAt, $updatedAt, $deletedAt
        ]) {
            $post = new Post();
            $post->setTitle($title);
            $this->faker->boolean(10) && $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setImage($image);
            $this->faker->boolean(80) && $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            if ($this->faker->boolean(80)) {
                $post->setCreatedAt($createAt);
                $post->setUpdatedAt($updatedAt);
            }
            $this->faker->boolean(10) && $post->setDeletedAt($deletedAt);

            $manager->persist($post);
        }
        $manager->flush();
    }

    private function getPostData(): array
    {
        $posts = [];
        foreach (range(1, 50) as $i) {
            $posts[] = [
                // $title, $slug, $summary, $content, $image, $publishedAt, $author, $createAt, $updatedAt, $deletedAt
                $this->faker->unique()->word . ' ' . $this->faker->words($this->faker->randomDigit, true),
                $this->faker->unique()->slug,
                $this->faker->text(255),
                $this->faker->realText(1000),
                '', // TODO image
                $this->faker->dateTimeBetween('-6 months', 'now'),
                $this->faker->userName, // TODO author
                $this->faker->dateTimeBetween('-2 years', '-1 years'),
                $this->faker->dateTimeBetween('-1 years', '-6 months'),
                $this->faker->dateTimeBetween('-6 months', 'now')
            ];
        }
        return $posts;
    }
}
