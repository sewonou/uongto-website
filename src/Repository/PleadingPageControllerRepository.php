<?php

namespace App\Repository;

use App\Entity\PleadingPageController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PleadingPageController>
 *
 * @method PleadingPageController|null find($id, $lockMode = null, $lockVersion = null)
 * @method PleadingPageController|null findOneBy(array $criteria, array $orderBy = null)
 * @method PleadingPageController[]    findAll()
 * @method PleadingPageController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PleadingPageControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PleadingPageController::class);
    }

    public function save(PleadingPageController $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PleadingPageController $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PleadingPageController[] Returns an array of PleadingPageController objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PleadingPageController
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
