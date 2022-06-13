<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 13/06/2022
 * Time: 20:02
 */

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserValidatorTest extends KernelTestCase
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