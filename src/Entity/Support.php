<?php

namespace App\Entity;

use App\Repository\SupportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupportRepository::class)]
#[ORM\Table(name:"support")]
class Support
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $contents;

    #[ORM\ManyToOne(inversedBy: 'support')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'support')]
    #[ORM\JoinColumn(nullable: false)]
    private Companies $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getCompany(): Companies
    {
        return $this->company;
    }

    public static function create(
        string $name,
        string $contents,
        User $user,
        Companies $companies,
    ): self{
        $support = new Support();
        $support->name = $name;
        $support->contents = $contents;
        $support->user = $user;
        $support->company = $companies;

        return $support;
    }
}
