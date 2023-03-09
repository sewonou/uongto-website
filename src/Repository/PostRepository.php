<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByActiveAndPublished(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isActive = :val')
            ->andWhere('p.isPublished= :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPage($page): array
    {

        return $this->createQueryBuilder('p')
            ->where('p.page = :page')
            ->andWhere('p.isActive = :val')
            ->andWhere('p.isPublished= :val')
            ->setParameters(['val'=>true, 'page'=>$page])
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findLatestPost(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isActive = :val')
            ->andWhere('p.isPublished= :val')
            ->setParameter('val', true)
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function findBestPost(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isActive = :val')
            ->andWhere('p.isPublished = :val')
            ->andWhere('p.count >= :count')
            ->setParameters(['val' => true, 'count' => 10 ])
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

    public function updateCount($post)
    {
        /*dump($post->getCount() +1 );
        die();*/
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.count ', ':val')
            ->setParameter('val',$post->getCount() +1 )
            ->where( 'p.id = :val2')
            ->setParameter('val2', $post->getId())
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Post[] Returns an array of Post objects
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

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
