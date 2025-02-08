<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name:"tool")]
class Tool
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(nullable: true)]
    private bool $isReserved;

    #[ORM\ManyToOne(inversedBy: 'tool')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $company;

    #[ORM\ManyToOne(inversedBy: 'tool')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Client $client = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isReserved(): bool
    {
        return $this->isReserved;
    }

    public function setIsReserved(bool $isReserved): void
    {
        $this->isReserved = $isReserved;
    }

    public function getCompany(): Companies
    {
        return $this->company;
    }

    public function setCompany(Companies $company): void
    {
        $this->company = $company;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public static function create(
        string $name,
        Companies $companies,
    ): self{
        $tool = new Tool();
        $tool->name = $name;
        $tool->company = $companies;
        $tool->isReserved = false;

        return $tool;
    }
}
