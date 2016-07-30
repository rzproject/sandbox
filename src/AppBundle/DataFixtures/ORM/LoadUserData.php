<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Bundle\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    function getOrder()
    {
        return 4;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $manager = $this->getUserManager();
        $faker = $this->getFaker();

        $user = $manager->createUser();
        $user->setUsername('admin');
        $user->setEmail($faker->safeEmail);
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->setFirstname('Juan');
        $user->setLastname('Dela Cruz');
        $user->setGender('m');
        $user->setDateOfBirth(new \DateTime('1998-06-30'));


        $manager->updateUser($user);

        $user = $manager->createUser();
        $user->setUsername('secure');
        $user->setEmail($faker->safeEmail);
        $user->setPlainPassword('secure');
        $user->setEnabled(true);
        $user->setSuperAdmin(true);
        $user->setLocked(false);
        // google chart qr code : https://www.google.com/chart?chs=200x200&chld=M|0&cht=qr&chl=otpauth://totp/secure@http://demo.sonata-project.org%3Fsecret%3D4YU4QGYPB63HDN2C
        $user->setTwoStepVerificationCode('4YU4QGYPB63HDN2C');
        $user->setFirstname('Juana');
        $user->setLastname('Dela Cruz');
        $user->setGender('f');
        $user->setDateOfBirth(new \DateTime('1999-07-01'));

        $manager->updateUser($user);

        $this->addReference('user-admin', $user);

        //MALE
        foreach (range(1, 10) as $id) {
            $user = $manager->createUser();

            $fname = $faker->unique()->firstNameMale;
            $lname = $faker->unique()->lastName;
            $uname = strtolower(sprintf('%s.%s', $fname, $lname));
            $email = strtolower(sprintf('%s@%s', $uname, $faker->freeEmailDomain))

            $user->setUsername($uname);
            $user->setEmail($email);
            $user->setPlainPassword('password');
            $user->setEnabled(true);
            $user->setLocked(false);
            $user->setFirstname(ucfirst($fname));
            $user->setLastname(ucfirst($lname));
            $user->setGender('f');
            $user->setDateOfBirth($faker->dateTimeBetween('-85 years', '-11 years'));

            $manager->updateUser($user);
        }

        //FEMALE
        foreach (range(1, 10) as $id) {
            $user = $manager->createUser();

            $fname = $faker->unique()->firstNameFemale;
            $lname = $faker->unique()->lastName;
            $uname = strtolower(sprintf('%s.%s', $fname, $lname));
            $email = strtolower(sprintf('%s@%s', $uname, $faker->freeEmailDomain))

            $user->setUsername($uname);
            $user->setEmail($email);
            $user->setPlainPassword('password');
            $user->setEnabled(true);
            $user->setLocked(false);
            $user->setFirstname(ucfirst($fname));
            $user->setLastname(ucfirst($lname));
            $user->setGender('f');
            $user->setDateOfBirth($faker->dateTimeBetween('-85 years', '-11 years'));

            $manager->updateUser($user);
        }

        // Behat testing purpose
        $user = $manager->createUser();
        $user->setUsername('behat_user');
        $user->setEmail('behat.user@behat.org');
        $user->setEnabled(true);
        $user->setPlainPassword('behat');
        $user->setFirstname('Jane');
        $user->setLastname('Behat');
        $user->setGender('f');
        $user->setDateOfBirth($faker->dateTimeBetween('-85 years', '-11 years'));
        $manager->updateUser($user);
    }

    /**
     * @return \FOS\UserBundle\Model\UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->container->get('fos_user.user_manager');
    }

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->container->get('faker.generator');
    }
}
