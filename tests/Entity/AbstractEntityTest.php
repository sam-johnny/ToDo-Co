<?php

/**
 * Created by PhpStorm.
 * User: SAM Johnny
 * Date: 13/05/2022
 * Time: 03:20
 */

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractEntityTest extends KernelTestCase
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
}