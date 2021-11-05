<?php

namespace App\Repository;

use App\Entity\SkillLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillLevel[]    findAll()
 * @method SkillLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillLevel::class);
    }

    // /**
    //  * @return SkillLevel[] Returns an array of SkillLevel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SkillLevel
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
