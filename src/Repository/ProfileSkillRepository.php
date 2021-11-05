<?php

namespace App\Repository;

use App\Entity\ProfileSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfileSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileSkill[]    findAll()
 * @method ProfileSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileSkill::class);
    }

    // /**
    //  * @return ProfileSkill[] Returns an array of ProfileSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfileSkill
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
