<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\WalletsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=WalletsRepository::class)
 */
class Wallets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Cliente al que pertenece
     * @var \AppBundle\Entity\Clients
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Clients")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $client;

    /**
     * @ORM\Column(type="float")
     */
    private $balance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dinamicToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdClient(): ?string
    {
        return $this->idClient;
    }

    public function setIdClient(string $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getDinamicToken(): ?int
    {
        return $this->dinamicToken;
    }

    public function setDinamicToken(?int $dinamicToken): self
    {
        $this->dinamicToken = $dinamicToken;

        return $this;
    }
}
