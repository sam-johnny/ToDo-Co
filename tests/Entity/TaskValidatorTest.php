<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 13/06/2022
 * Time: 20:07
 */

namespace App\Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskValidatorTest extends KernelTestCase
{
    protected \DateTime $datetime;
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

    public function setTask(): Task
    {
        $this->datetime = new \DateTime();
        return (new Task())
            ->setTitle('Titre')
            ->setContent('Je suis le contenu')
            ->setCreatedAt($this->datetime)
            ->setIsDone(false)
            ->setUser(null);
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->setTask(), 0);
    }

    public function testInvalidBlankTitleEntity()
    {
        $this->assertHasErrors($this->setTask()->setTitle(''), 1);
    }

    public function testInvalidBlankContentEntity()
    {
        $this->assertHasErrors($this->setTask()->setContent(''), 1);
    }
}