<?php
namespace App\Tests\Entity;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class UserTest extends AbstractEntityTest
{
    protected AbstractDatabaseTool $databaseTool;

    public function setUp(): void
    {
        parent::setUp();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): User
    {
        return (new User())
            ->setUsername('Jysaaa')
            ->setPassword('Password')
            ->setEmail('jysaaa@hotmail.fr');
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 2);
        $this->assertHasErrors($this->getEntity()->setPassword(''), 2);
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testInvalidMinLenghtEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername('Pa'), 1);
        $this->assertHasErrors($this->getEntity()->setPassword('Pa'), 1);
    }

    public function testInvalidMaxLenghtEntity()
    {
        $username = 'azertyuiopqsdfghjklmwxscdvvdvfbfbcvb';

        $this->assertHasErrors($this->getEntity()->setUsername($username), 1);
    }

    public function testInvalidUniqueEntity()
    {
        $this->databaseTool->loadFixtures([UserFixtures::class]);
        $this->assertHasErrors($this->getEntity()->setUsername('user0'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('user6@hotmail.fr'), 1);
    }

    public function testInvalidEmailEntity()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('gjeojgeijigoe'), 1);
    }

}