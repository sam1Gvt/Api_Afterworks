<?php

namespace App\Repository;

use App\Entity\ProduitCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProduitCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitCommande[]    findAll()
 * @method ProduitCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitCommande::class);
    }

    public function getProduitsCommand($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT pc.quantiteProduit, pc.prixHt, pc.montantTva, p.libelleProduit, d.libelleDeclinaison, pc.idProduitCommande
                     FROM App:ProduitCommande pc 
                     JOIN App:Produit p WITH pc.idProduit = p.idProduit
                     JOIN App:DeclinaisonProduit dp WITH pc.idDeclinaisonProduit = dp.idDeclinaisonProduit
                     JOIN App:Declinaison d WITH dp.idDeclinaison = d.idDeclinaison 
                     WHERE pc.idCommande = '.$id.'
                     '
            )
            ->getResult();
    }
    /* JOIN App:DeclinaisonProduit dp WITH pc.idDeclinaisonProduit = dp.idDeclinaisonProduit*/

    // /**
    //  * @return ProduitCommande[] Returns an array of ProduitCommande objects
    //  */
    /*
     *     'SELECT pc.quantiteProduit, pc.prixHt, pc.montantTva, p.libelleProduit
                     FROM App:ProduitCommande pc
                     JOIN App:Produit p WITH pc.idProduit = p.idProduit
                     WHERE pc.idCommande = '.$id.'
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
    public function findOneBySomeField($value): ?ProduitCommande
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
