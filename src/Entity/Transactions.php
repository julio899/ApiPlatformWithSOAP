<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Wallet que realizo la tansaccion
     * @var \AppBundle\Entity\Wallets
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Wallets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wallet_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idWallet;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdWallet(): ?int
    {
        return $this->idWallet;
    }

    public function setIdWallet(int $idWallet): self
    {
        $this->idWallet = $idWallet;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}
