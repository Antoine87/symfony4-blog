<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use App\Utils\Arr;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var User[]
     */
    private $users;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->faker = Factory::create();
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadPosts($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [
            $firstname, $lastname, $login, $email, $password, $createdAt, $updatedAt, $deletedAt
        ]) {
            $user = new User();
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            if (isset($createdAt, $updatedAt) && $this->faker->boolean(80)) {
                $user->setCreatedAt($createdAt);
                $user->setUpdatedAt($updatedAt);
            }
            $this->faker->boolean(10) && $user->setDeletedAt($deletedAt);

            $manager->persist($user);
            $this->addReference($login, $user);
            $this->users[] = $user;
        }
        $manager->flush();
    }

    private function loadPosts(ObjectManager $manager): void
    {
        foreach ($this->getPostData() as [
            $title, $slug, $summary, $content, $image, $publishedAt, $author, $createdAt, $updatedAt, $deletedAt
        ]) {
            $post = new Post();
            $post->setTitle($title);
            $this->faker->boolean(10) && $post->setSlug($slug);
            $post->setSummary($summary);
            $post->setContent($content);
            $post->setImage($image);
            $this->faker->boolean(80) && $post->setPublishedAt($publishedAt);
            $post->setAuthor($author);
            if (isset($createdAt, $updatedAt) && $this->faker->boolean(80)) {
                $post->setCreatedAt($createdAt);
                $post->setUpdatedAt($updatedAt);
            }
            $this->faker->boolean(10) && $post->setDeletedAt($deletedAt);

            $manager->persist($post);
        }
        $manager->flush();
    }

    /**
     * @return array[]
     */
    private function getUserData(): array
    {
        $users = [
            // $firstname, $lastname, $login, $email, $password, $createdAt, $updatedAt, $deletedAt
            [null, null, 'admin', 'admin@mail.com', 'secret', null, null, null],
            ['Barack', 'Obama', 'b-obama', 'potus@washington.com', 'secret', null, null, null]
        ];

        foreach (range(1, 30) as $i) {
            $users[] = [
                $this->faker->firstName,
                $this->faker->lastName,
                $this->faker->unique()->word,
                $this->faker->email,
                $this->faker->password,
                $this->faker->dateTimeBetween('-2 years', '-1 years'),
                $this->faker->dateTimeBetween('-1 years', '-6 months'),
                $this->faker->dateTimeBetween('-6 months', 'now')
            ];
        }
        return $users;
    }

    /**
     * @return array[]
     */
    private function getPostData(): array
    {
        $posts = [
            // $title, $slug, $summary, $content, $image, $publishedAt, $author, $createAt, $updatedAt, $deletedAt
        ];

        foreach (range(1, 50) as $i) {
            $posts[] = [
                $this->faker->unique()->word . ' ' . $this->faker->words($this->faker->randomDigit, true),
                $this->faker->unique()->slug,
                $this->faker->text(255),
                $this->faker->realText(1000),
                '', // TODO image
                $this->faker->dateTimeBetween('-6 months', 'now'),
                Arr::random($this->users),
                $this->faker->dateTimeBetween('-2 years', '-1 years'),
                $this->faker->dateTimeBetween('-1 years', '-6 months'),
                $this->faker->dateTimeBetween('-6 months', 'now')
            ];
        }
        return $posts;
    }
}
