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
        $date = new \DateTime('-3 days', new \DateTimeZone('Europe/Paris'));
        $qb = $this->createQueryBuilder('r');

        $qb->andWhere("r.driver = :driver");
        $qb->andWhere("r.departureDate >= :date");
        $qb->setParameter(':date', $date);
        $qb->setParameter(':driver', $user);
        $qb->addOrderBy('r.departureDate', 'DESC');
        $qb->addOrderBy('r.departureTime', 'ASC');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function searchRun(string $departure, string $arrival, \DateTime $date){

        $date = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

        $qb = $this->createQueryBuilder('r');

        $qb->andWhere("r.departureDate >= :date");
        $qb->setParameter(':date', $date);

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

    // créer un objet json de la table run
    /*public function objectJson(){
        try 
        {
            $dbh = new PDO('mysql://root@127.0.0.1:3306/papotecar');
    
            $rq = $dbh->query('SELECT * FROM run');
            $obj = $rq->fetchAll();
    
            // conversion en json
            $json_output = json_encode($obj);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }*/
}
