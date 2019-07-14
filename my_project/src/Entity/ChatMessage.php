<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatMessageRepository")
 */
class ChatMessage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShopUser", inversedBy="chatMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ShopUser", inversedBy="inboxMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distenation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAuthor(): ?ShopUser
    {
        return $this->author;
    }

    public function setAuthor(?ShopUser $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDistenation(): ?ShopUser
    {
        return $this->distenation;
    }

    public function setDistenation(?ShopUser $distenation): self
    {
        $this->distenation = $distenation;

        return $this;
    }
}
