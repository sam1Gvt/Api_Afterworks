<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function getAllCommandsWithStatutName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c.idCommande, c.dateCommande, c.noTable, c.idStatut, s.libelleStatut
                     FROM App:Commande c 
                     JOIN App:StatutCommande s WITH c.idStatut = s.idStatut
                     WHERE c.idStatut <> 2 AND c.idStatut <> 6 AND c.idStatut <> 7 AND c.idStatut <> 8 AND c.idStatut <> 9 AND c.idStatut <> 10
                     '
            )
            ->getResult();
    }

    public function getStatutCommand($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s.libelleStatut
                     FROM App:Commande c 
                     JOIN App:StatutCommande s WITH c.idStatut = s.idStatut
                     WHERE c.idCommande = '.$id.'
                     '
            )
            ->getResult();
    }

    // /**  */
    //  * @return Commande[] Returns an array of Commande objects
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
    public function findOneBySomeField($value): ?Commande
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
