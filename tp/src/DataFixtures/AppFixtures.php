<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\User;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        $admin = new User();
        $admin->setFirstName('test1')
            ->setLastName('Dupont')
            ->setEmail('test1@admin.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_ADMIN'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($admin);

        $user = new User();
        $user->setFirstName('test2')
            ->setLastName('Machin')
            ->setEmail('test2@example.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        $bannedUser = new User();
        $bannedUser->setFirstName('test3')
            ->setLastName('Truc')
            ->setEmail('test3@banned.com')
            ->setPassword(password_hash('password', PASSWORD_BCRYPT))
            ->setRoles(['ROLE_BANNED'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($bannedUser);

        $manager->flush();
    }
}
