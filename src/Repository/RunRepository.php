<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\Run;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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

        $qb->andWhere("r.driver = :driver");
        $qb->setParameter(':driver', $user);
        $qb->addOrderBy('r.departureDate', 'ASC');
        $qb->addOrderBy('r.departureTime', 'ASC');

        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function searchRun(string $departure, string $arrival, \DateTime $date){

        $datedefault = new \DateTime('now 00:00');
        $timedefault = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

        $qb = $this->createQueryBuilder('r');

        $qb->andWhere("r.departureDate = :date");
        $qb->setParameter(':date', $date);

        if ($date == $datedefault) {
            $qb->andWhere("r.departureTime > :nowtime");
            $qb->setParameter(':nowtime', $timedefault);
        }

        $qb->andWhere("r.departure LIKE :departure");
        $qb->andWhere("r.arrival LIKE :arrival");

        $qb->setParameter(':departure', $departure.'%');
        $qb->setParameter(':arrival', $arrival.'%');
        $qb->addOrderBy('r.departureDate', 'ASC');
        $qb->addOrderBy('r.departureTime', 'ASC');
        $qb->leftJoin('r.driver', 'd')->addSelect('d');

        $qb->setMaxResults(50);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
