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
        $qb->addOrderBy('r.departureDate', 'ASC');
        $qb->addOrderBy('r.departureTime', 'ASC');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function searchRunByDepartureArrivalAndDate(Run $run ){

        $day = date_format($date,'d');
        $month=date_format($date,'m');
        $year = date_format($date,'Y');
        $qb = $this->createQueryBuilder('r');
//        $dateDay = explode('-',);
//        var_dump($dateDay[1]);
        $qb->andWhere("r.departure = :departure");
        $qb->andWhere("r.arrival = :arrival");
        $qb->andWhere("r.departure");
        $qb->andWhere('DAY(r.departureSchedule) = :day');
        $qb->andWhere("month(r.departureSchedule) = :month ");
        $qb->andWhere("year(r.departureSchedule) = :year ");
        $qb->setParameter(":departure",$departure);
        $qb->setParameter(":arrival",$arrival);
        $qb->setParameter(":day", $day);
        $qb->setParameter(":month",$month);
        $qb->setParameter(":year",$year);

        $query  = $qb->getQuery();
        return $query->getResult();

    }
}
