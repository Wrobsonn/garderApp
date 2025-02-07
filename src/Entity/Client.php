<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name:"client")]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    private string $clientName;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $companyName = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $nip = null;

    #[ORM\Column(length: 10)]
    private string $postCode;

    #[ORM\Column(length: 50)]
    private string $city;

    #[ORM\Column(length: 50)]
    private string $street;

    #[ORM\ManyToOne(inversedBy: 'client')]
    #[ORM\JoinColumn(nullable: false)]
    private Companies $company;


    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(?string $nip): void
    {
        $this->nip = $nip;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }
    public static function create(
        string $clientName,
        ?string $companyName,
        ?string $nip,
        string $postCode,
        string $city,
        string $street,
        Companies $companies,
    ): self{
        $client = new Client();
        $client->clientName = $clientName;
        $client->companyName = $companyName;
        $client->nip = $nip;
        $client->postCode = $postCode;
        $client->city = $city;
        $client->street = $street;
        $client->company = $companies;

        return $client;
    }

    public function getCompany(): Companies
    {
        return $this->company;
    }

    public function setCompany(Companies $company): void
    {
        $this->company = $company;
    }
}
