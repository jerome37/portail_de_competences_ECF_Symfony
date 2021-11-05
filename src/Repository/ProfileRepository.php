<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;
    
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Profile::class);
        $this->em = $em;
    }

    // /**
    //  * @return Profile[] Returns an array of Profile objects
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
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function searchProfiles($name, $skill, $level, $appreciation)
    {
        $search = $this->em->createQueryBuilder();

        $results = $search->select('p, st, ps, s, l')
                          ->from('App\Entity\Profile', 'p')
                          ->leftJoin('p.profileSkills', 'ps')
                          ->leftJoin('p.status', 'st')
                          ->leftJoin('ps.skill', 's')
                          ->leftJoin('ps.level', 'l');

                          if($name)
                          {
                            $search->andWhere(
                                        $search->expr()->orX(
                                            $search->expr()->like('p.firstname', $search->expr()->literal('%'.$name.'%')),
                                            $search->expr()->like('p.lastname', $search->expr()->literal('%'.$name.'%'))
                                        )
                                    )
                                    ->andWhere(
                                        $search->expr()->orX(
                                            $search->expr()->like('st.name', $search->expr()->literal('candidat')),
                                            $search->expr()->like('st.name', $search->expr()->literal('collaborateur'))
                                        )
                                    );
                          }

                          if($skill){
                            $search->andwhere(
                                $search->expr()->eq('s.name', "'".$skill."'")
                            );
                          }

                          if($level){
                            $search->andwhere(
                                $search->expr()->eq('l.status', "'".$level."'")
                            );
                          }

                          if($appreciation === 'on')
                          {
                            $search->andwhere(
                                $search->expr()->eq('ps.appreciation', '1')
                            );
                          }
                          

        return $search->getQuery()->getResult();
    }

    public function getNewCandidates()
    {
        $request = $this->em->createQueryBuilder();

        $request->select('p', 's')
                ->from('App\Entity\Profile', 'p')
                ->join('p.status', 's')
                ->where("s.name = 'candidat'")
                ->orderBy('p.date_modification', 'DESC')
                ->setMaxresults(10);
        
        return $request->getQuery()->getResult();
    }

    public function getAllCandidates()
    {
        $request = $this->em->createQueryBuilder();

        $request->select('p', 's')
                ->from('App\Entity\Profile', 'p')
                ->join('p.status', 's')
                ->where("s.name = 'candidat'");
        
        return $request->getQuery()->getResult();
    }

    public function getNewCollaborators()
    {
        $request = $this->em->createQueryBuilder();

        $request->select('p', 'u', 's')
                ->from('App\Entity\Profile', 'p')
                ->join('p.user', 'u')
                ->join('p.status', 's')
                ->where("s.name = 'collaborateur'")
                ->orderBy('u.date', 'DESC')
                ->setMaxresults(10);
        
        return $request->getQuery()->getResult();
    }

    public function getAllCollaborators()
    {
        $request = $this->em->createQueryBuilder();

        $request->select('p', 's')
                ->from('App\Entity\Profile', 'p')
                ->join('p.status', 's')
                ->where("s.name = 'collaborateur'");
        
        return $request->getQuery()->getResult();
    }

    public function getModifiedProfiles()
    {
        $request = $this->em->createQuery(
            'SELECT p
            FROM App\Entity\Profile p
            WHERE p.date_modification IS NOT NULL
            ORDER BY p.date_modification DESC'
        )->setMaxResults(10);

        return $request->getResult();
    }
}