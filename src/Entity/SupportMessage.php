<?php

namespace App\Entity;

use App\Repository\SupportMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupportMessageRepository::class)]
#[ORM\Table(name:"support_message")]
class SupportMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $contents;

    #[ORM\ManyToOne(inversedBy: 'support_message')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(inversedBy: 'support_message')]
    #[ORM\JoinColumn(nullable: false)]
    private Support $support;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSupport(): Support
    {
        return $this->support;
    }

    public static function create(
        string $contents,
        User $user,
        Support $support,
    ): self{
        $supportMessage = new SupportMessage();
        $supportMessage->contents = $contents;
        $supportMessage->user = $user;
        $supportMessage->support = $support;

        return $supportMessage;
    }

}
