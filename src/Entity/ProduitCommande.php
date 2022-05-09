<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduitCommande
 *
 * @ORM\Table(name="produit_commande", indexes={@ORM\Index(name="fkIdx_182", columns={"id_declinaison_produit"}), @ORM\Index(name="fkIdx_32", columns={"id_commande"}), @ORM\Index(name="fk_idProduit", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitCommandeRepository")
 */
class ProduitCommande
{

    /**
     * @var int
     *
     * @ORM\Column(name="id_produit_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduitCommande;
    /**
     * @var float
     *
     * @ORM\Column(name="prix_HT", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixHt;

    /**
     * @var float
     *
     * @ORM\Column(name="montant_TVA", type="float", precision=10, scale=0, nullable=false)
     */
    private $montantTva;

    /**
     * @var int
     *
     * @ORM\Column(name="id_declinaison_produit", type="integer", nullable=false)
     */
    private $idDeclinaisonProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="quantité_produit", type="integer", nullable=false)
     */
    private $quantiteProduit;




    /**
     *
     * @var int
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     */
    private $idProduit;

    /**
     * @var int
     * @ORM\Column(name="id_commande", type="integer", nullable=false)

     */
    private $idCommande;





    public function getIdProduit(): int
    {
        return $this->idProduit;
    }


    public function setIdProduit(int $idProduit): void
    {
        $this->idProduit = $idProduit;
    }


    public function getIdProduitCommande(): int
    {
        return $this->idProduitCommande;
    }


    public function setIdProduitCommande(int $idProduitCommande): void
    {
        $this->idProduitCommande = $idProduitCommande;
    }


    public function getIdCommande()
    {
        return $this->idCommande;
    }


    public function setIdCommande(int $idCommande)
    {
        return $this->idCommande = $idCommande;

    }



    public function getIdDeclinaisonProduit(): ?int
    {
        return $this->idDeclinaisonProduit;
    }

    public function setIdDeclinaisonProduit(int $idDeclinaisonProduit): self
    {
        $this->idDeclinaisonProduit = $idDeclinaisonProduit;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantiteProduit(): int
    {
        return $this->quantiteProduit;
    }

    /**
     * @param int $quantiteProduit
     */
    public function setQuantiteProduit(int $quantiteProduit): void
    {
        $this->quantiteProduit = $quantiteProduit;
    }




    public function getPrixHt(): ?float
    {
        return $this->prixHt;
    }

    public function setPrixHt(float $prixHt): self
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    public function getMontantTva(): ?float
    {
        return $this->montantTva;
    }

    public function setMontantTva(float $montantTva): self
    {
        $this->montantTva = $montantTva;

        return $this;
    }




}
