<?php

namespace App\Repository;

use App\Entity\CategorieMove;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CategorieMove|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieMove|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieMove[]    findAll()
 * @method CategorieMove[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieMoveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CategorieMove::class);
    }

    // /**
    //  * @return CategorieMove[] Returns an array of CategorieMove objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieMove
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
