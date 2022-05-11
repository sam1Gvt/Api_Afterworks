<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;



/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter
{


    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="email", type="text", length=65535, nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $email;


    /**
     * @var boolean
     *
     * @ORM\Column(name="activation", type="boolean", nullable=false)
     */
    private $abonnementNewsletter;

    /**
     * @return bool
     */
    public function isAbonnementNewsletter(): bool
    {
        return $this->abonnementNewsletter;
    }

    /**
     * @param bool $abonnementNewsletter
     */
    public function setAbonnementNewsletter(bool $abonnementNewsletter): void
    {
        $this->abonnementNewsletter = $abonnementNewsletter;
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



}