<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\ResultatCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResultatCourse>
 *
 * @method ResultatCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultatCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultatCourse[]    findAll()
 * @method ResultatCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultatCourse::class);
    }

    public function save(ResultatCourse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ResultatCourse $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findResCourseOrder(Course $unecourse) : array
    {
        return $this->createQueryBuilder('rc')
                ->where('rc.uneCourse = :result')
                ->setParameter('result', $unecourse)
                ->orderBy('rc.temps')
                ->getQuery()
                ->getResult();
    }
//    /**
//     * @return ResultatCourse[] Returns an array of ResultatCourse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResultatCourse
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
