<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }

    public function addClient($client)
    {
        return;
    }
    
    public function findClient($client)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.email = :val')
            ->setParameter('val', $client['email'])
            ->andWhere('c.document = :document')
            ->setParameter('document', $client['document'])
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Clients[] Returns an array of Clients objects
    //  */
    /*
    public function findAll()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', 3)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    */

    /*
    public function findOneBySomeField($value): ?Clients
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
