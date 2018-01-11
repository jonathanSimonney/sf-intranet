<?php

namespace App\Repository;

use App\Entity\Grade;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GradeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    public function getGroupedGrade(User $user)
    {
        return $this->createQueryBuilder('g')
            ->select('g AS grade')
            ->addSelect('sub.name AS subjectName')
            //->addSelect('SUM(g.value)/COUNT(g) AS average')
            ->where('g.owner = :user')->setParameter('user', $user)
            ->andWhere('g.subject IN (:subjectList)')->setParameter('subjectList', $user->getLearnedSubjects()->toArray())
            //->groupBy('sub.name')
            ->leftJoin('g.subject', 'sub')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('g')
            ->where('g.something = :value')->setParameter('value', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
