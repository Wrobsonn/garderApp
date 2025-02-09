<?php

namespace App\Entity;

use App\Repository\AssignedWorkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignedWorkRepository::class)]
#[ORM\Table(name:"assigned_work")]
class AssignedWork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assigned_work')]
    #[ORM\JoinColumn(nullable: false)]
    private Job $job;

    #[ORM\Column(length: 5)]
    private int $hour;

    #[ORM\Column(length: 5)]
    private int $minute;

    #[ORM\ManyToOne(inversedBy: 'assigned_work')]
    #[ORM\JoinColumn(nullable: false)]
    private Companies $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJob(): Job
    {
        return $this->job;
    }

    public function setJob(Job $job): void
    {
        $this->job = $job;
    }

    public function getCompany(): Companies
    {
        return $this->company;
    }

    public function setCompany(Companies $company): void
    {
        $this->company = $company;
    }

    public static function create(
        int $hour,
        int $minute,
        Job $job,
        Companies $companies,
    ): self{
        $assignedWork = new AssignedWork();
        $assignedWork->hour = $hour;
        $assignedWork->minute = $minute;
        $assignedWork->job = $job;
        $assignedWork->company = $companies;

        return $assignedWork;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function setHour(int $hour): void
    {
        $this->hour = $hour;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): void
    {
        $this->minute = $minute;
    }
}
