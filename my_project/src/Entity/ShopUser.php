<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopUserRepository")
 * @UniqueEntity(fields={"email"}, message="Данный e-Mail уже используется в системе")
 */
class ShopUser implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(allowNull = true)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Book", mappedBy="author")
     */
    private $books;


    public function __construct()
    {
        $this->books = new ArrayCollection();
//        $this->chatMessages = new ArrayCollection();
//        $this->inboxMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            // set the owning side to null (unless already changed)
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

//        return $this;
//    }
//
//    /**
//     * @return Collection|ChatMessage[]
//     */
//    public function getChatMessages(): Collection
//    {
//        return $this->chatMessages;
//    }
//
//    public function addChatMessage(ChatMessage $chatMessage): self
//    {
//        if (!$this->chatMessages->contains($chatMessage)) {
//            $this->chatMessages[] = $chatMessage;
//            $chatMessage->setAuthor($this);
//        }
//
//        return $this;
//    }
//
//    public function removeChatMessage(ChatMessage $chatMessage): self
//    {
//        if ($this->chatMessages->contains($chatMessage)) {
//            $this->chatMessages->removeElement($chatMessage);
//            // set the owning side to null (unless already changed)
//            if ($chatMessage->getAuthor() === $this) {
//                $chatMessage->setAuthor(null);
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * @return Collection|ChatMessage[]
//     */
//    public function getInboxMessages(): Collection
//    {
//        return $this->inboxMessages;
//    }
//
//    public function addInboxMessage(ChatMessage $inboxMessage): self
//    {
//        if (!$this->inboxMessages->contains($inboxMessage)) {
//            $this->inboxMessages[] = $inboxMessage;
//            $inboxMessage->setDistenation($this);
//        }
//
//        return $this;
//    }
//
//    public function removeInboxMessage(ChatMessage $inboxMessage): self
//    {
//        if ($this->inboxMessages->contains($inboxMessage)) {
//            $this->inboxMessages->removeElement($inboxMessage);
//            // set the owning side to null (unless already changed)
//            if ($inboxMessage->getDistenation() === $this) {
//                $inboxMessage->setDistenation(null);
//            }
//        }

        return $this;
    }
}
