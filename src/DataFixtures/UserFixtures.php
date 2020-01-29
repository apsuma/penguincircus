<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('delphine.belet@gmail.com');
        $admin->setFirstName('Glap');
        $admin->setLastName('PinguiCircus');
        $admin->setRoles([User::ROLE_ADMIN]);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));
        $manager->persist($admin);

        $user1 = new User();
        $user1->setEmail('user1@laposte.net');
        $user1->setFirstName('Empereur');
        $user1->setLastName('MaColonieEmpereur');
        $user1->setRoles([User::ROLE_USER]);
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1,
            'userpassword'
        ));
        $manager->persist($user1);
        $manager->flush();
    }
}