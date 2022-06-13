<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function setUser(): User
    {
        return (new User())
            ->setUsername('Jysaaa')
            ->setPassword('Password')
            ->setEmail('jysaaa@hotmail.fr')
            ->setRoles(['ROLE_ADMIN']);
    }

    public function testIsTrueGetUsername()
    {
        $this->assertTrue($this->setUser()->getUsername() === 'Jysaaa');
    }

    public function testIsTrueGetPassword()
    {
        $this->assertTrue($this->setUser()->getPassword() === 'Password');
    }

    public function testIsTrueGetEmail()
    {
        $this->assertTrue($this->setUser()->getEmail() === 'jysaaa@hotmail.fr');
    }

    public function testIsTrueGetRoles()
    {
        $this->assertTrue($this->setUser()->getRoles() === ['ROLE_ADMIN']);
    }

    public function testIsTrueGetSalt()
    {
        $this->assertTrue($this->setUser()->getSalt() === null);
    }

    public function testIsFalseGetUsername()
    {
        $this->assertFalse($this->setUser()->getUsername() === 'hahaha');
    }

    public function testIsFalseGetPassword()
    {
        $this->assertFalse($this->setUser()->getPassword() === 'hahaha');
    }

    public function testIsFalseGetEmail()
    {
        $this->assertFalse($this->setUser()->getEmail() === 'hahaha');
    }

    public function testIsFalseGetRoles()
    {
        $this->assertFalse($this->setUser()->getRoles() === ['ROLE_USER']);
    }

    public function testIsFalseGetSalt()
    {
        $this->assertFalse($this->setUser()->getSalt() === "hahah");
    }

    public function testIdIsEmpty()
    {
        $user = new User();
        $this->assertEmpty($user->getId());
    }

    public function testRoleIsEmpty()
    {
        $user = new User();
        $this->assertEmpty($user->getRoles());
    }
}
