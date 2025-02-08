<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
#[ORM\Table(name:"job")]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(length: 100)]
    private array $tools;

    #[ORM\ManyToOne(inversedBy: 'job')]
    #[ORM\JoinColumn(nullable: false)]
    private Companies $company;

    #[ORM\ManyToOne(inversedBy: 'job')]
    #[ORM\JoinColumn(nullable: false)]
    private Client $client;

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
        array $tools,
        Client $client,
    ): self{
        $job = new Job();
        $job->name = $name;
        $job->company = $companies;
        $job->tools = $tools;
        $job->client = $client;

        return $job;
    }

    public function getTools(): array
    {
        return $this->tools;
    }

    public function setTools(array $tools): void
    {
        $this->tools = $tools;
    }
}
