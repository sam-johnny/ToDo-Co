<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    protected ValidatorInterface $validator;

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    public function assertHasErrors($entity, int $number)
    {
        $errors = $this->validator->validate($entity);

        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(', ', $messages));
    }
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

    public function testValidEntity()
    {
        $this->assertHasErrors($this->setUser(), 0);
    }

    public function testInvalidBlankUsernameEntity()
    {
        $this->assertHasErrors($this->setUser()->setUsername(''), 2);
    }

    public function testInvalidBlankPasswordEntity()
    {
        $this->assertHasErrors($this->setUser()->setPassword(''), 2);
    }

    public function testInvalidBlankEmailEntity()
    {
        $this->assertHasErrors($this->setUser()->setEmail(''), 1);
    }

    public function testInvalidMinLenghtUsernameEntity()
    {
        $this->assertHasErrors($this->setUser()->setUsername('Pa'), 1);
    }

    public function testInvalidMinLenghtPasswordEntity()
    {
        $this->assertHasErrors($this->setUser()->setPassword('Pa'), 1);
    }

    public function testInvalidMaxLenghtUsernameEntity()
    {
        $username = 'azertyuiopqsdfghjklmwxscdvvdvfbfbcvb';

        $this->assertHasErrors($this->setUser()->setUsername($username), 1);
    }

    public function testInvalidUniqueUsernameEntity()
    {
        $this->assertHasErrors($this->setUser()->setUsername('user0'), 1);
    }

    public function testInvalidUniqueEmailEntity()
    {
        $this->assertHasErrors($this->setUser()->setEmail('user6@hotmail.fr'), 1);
    }

    public function testInvalidEmailEntity()
    {
        $this->assertHasErrors($this->setUser()->setEmail('gjeojgeijigoe'), 1);
    }
}