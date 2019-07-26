<?php

namespace App\Repository;

use App\Entity\Permission;
use App\Entity\Tour;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tour[]    findAll()
 * @method Tour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TourRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tour::class);
    }

    public function findUserTours(User $user)
    {
        $qb = $this->createQueryBuilder('t')
            ->join('t.permissions', 'tp' )
            ->join('tp.user', 'tpu' )
            ->andWhere('tpu.id = :user')
            ->setParameter(':user', $user);


        return $qb->getQuery()->getResult();
    }

//TODO next 3 tours

//    /**
//     * @param int $limit
//     * @return Tour[]
//     */
//    public function findNextTours(int $limit = 3) : array
//    {
//        return $this->findBy([], ['startDate' => 'ASC'], $limit);
//    }

    // /**
    //  * @return Tour[] Returns an array of Tour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tour
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
