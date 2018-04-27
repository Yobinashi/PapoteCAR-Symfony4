<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Run;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Run|null find($id, $lockMode = null, $lockVersion = null)
 * @method Run|null findOneBy(array $criteria, array $orderBy = null)
 * @method Run[]    findAll()
 * @method Run[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RunRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Run::class);
    }

    public function selectRunsByDriversWhereDepartureSupNow(Member $user){
        $qb = $this->createQueryBuilder('r');

        $qb->andWhere("r.departureSchedule > :now");
        $qb->andWhere("r.driver = :driver");
        $qb->setParameter(':driver', $user);
        $qb->setParameter(':now', new \DateTime());
        $qb->addOrderBy('r.departureSchedule', 'ASC');

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
