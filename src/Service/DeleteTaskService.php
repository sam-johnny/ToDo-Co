<?php

namespace App\Service;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

class DeleteTaskService extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @throws Exception
     */
    public function deleteTaskAuto(): void
    {
        $connection = $this->getEntityManager()->getConnection();

        $sql = '
            DELETE FROM task
            WHERE created_at < date_sub(current_date, INTERVAL 364 DAY)
            ';

        $prepare = $connection->prepare($sql);
        $prepare->executeQuery();
    }
}
