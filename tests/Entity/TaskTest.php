<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskTest extends KernelTestCase
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

    public function testIsTrueGetTitle()
    {
        $this->assertTrue($this->setTask()->getTitle() === 'Titre');
    }

    public function testIsTrueGetContent()
    {
        $this->assertTrue($this->setTask()->getContent() === 'Je suis le contenu');
    }

    public function testIsTrueGetCreatedAt()
    {
        $this->assertTrue($this->setTask()->getCreatedAt() === $this->datetime);
    }

    public function testIsTrueGetIsDone()
    {
        $this->assertTrue($this->setTask()->getIsDone() === false);
    }

    public function testIdIsEmpty()
    {
        $task = new Task();
        $this->assertEmpty($task->getId());
    }

    public function testUserIsEmpty()
    {
        $task = new Task();
        $this->assertEmpty($task->getUser());
    }


    public function testIsFalseGetTitle()
    {
        $this->assertFalse($this->setTask()->getTitle() === 'hahaha');
    }

    public function testIsFalseGetContent()
    {
        $this->assertFalse($this->setTask()->getContent() === 'hahah');
    }

    public function testIsFalseGetIsDone()
    {
        $this->assertFalse($this->setTask()->getIsDone() === true);
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

    public function testAddTask()
    {
        $user = new User();
        $task = new Task();

        $user->addTask($task);
        $this->assertContains($task, $user->getTasks());
    }

    public function testRemoveTask()
    {
        $user= new User();
        $task = new Task();

        $user->removeTask($task);
        $this->assertNotContains($task, $user->getTasks());
    }
}