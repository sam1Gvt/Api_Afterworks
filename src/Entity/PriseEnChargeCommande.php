<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PriseEnChargeCommande
 *
 * @ORM\Table(name="prise_en_charge_commande")
 * @ORM\Entity(repositoryClass="App\Repository\PriseEnChargeCommandeRepository")
 */
class PriseEnChargeCommande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prise_en_charge", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPriseEnCharge;

    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     */
    private $idCommande;


    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     */
    private $username;


    /**
     * @var string
     *
     * @ORM\Column(name="statut_commande", type="string", length=200, nullable=false)
     */
    private $statutCommande;

    /**
     * @return int
     */
    public function getIdPriseEnCharge(): int
    {
        return $this->idPriseEnCharge;
    }

    /**
     * @param int $idPriseEnCharge
     */
    public function setIdPriseEnCharge(int $idPriseEnCharge): void
    {
        $this->idPriseEnCharge = $idPriseEnCharge;
    }

    /**
     * @return string
     */
    public function getIdCommande(): string
    {
        return $this->idCommande;
    }

    /**
     * @param string $idCommande
     */
    public function setIdCommande(string $idCommande): void
    {
        $this->idCommande = $idCommande;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }



    /**
     * @return string
     */
    public function getStatutCommande(): string
    {
        return $this->statutCommande;
    }

    /**
     * @param string $statutCommande
     */
    public function setStatutCommande(string $statutCommande): void
    {
        $this->statutCommande = $statutCommande;
    }


}

