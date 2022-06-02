<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * Récupère les tâches en lien avec une recherche
     * @param SearchData $search
     * @return array
     */
    public function findSearch(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('t.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->done)) {
            $query = $query
                ->andWhere('t.isDone = 1', 't.isDelete = 0');
        }

        if (!empty($search->toDo)) {
            $query = $query
                ->andWhere('t.isDone = 0');
        }

        if (!empty($search->delete)) {
            $query = $query
                ->andWhere('t.isDelete = 1');
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Task[] Returns an array of Task objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
