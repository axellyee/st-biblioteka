<?php

namespace App\Entity\Book;

use App\Repository\Book\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var ArrayCollection|RentedBook[]
     * @ORM\OneToMany(targetEntity=RentedBook::class, mappedBy="book", cascade={"remove"})
     */
    private $rentedBooks;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    public function __construct()
    {
        $this->rentedBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        if ($this->image != $image) {
            $this->image = $image;
        }

        return $this;
    }

    /**
     * @return Collection|RentedBook[]
     */
    public function getRentedBooks(): Collection
    {
        return $this->rentedBooks;
    }

    public function addRentedBook(RentedBook $rentedBook): self
    {
        if (!$this->rentedBooks->contains($rentedBook)) {
            $this->rentedBooks[] = $rentedBook;
            $rentedBook->setBook($this);
        }

        return $this;
    }

    public function removeRentedBook(RentedBook $rentedBook): self
    {
        if ($this->rentedBooks->removeElement($rentedBook)) {
            // set the owning side to null (unless already changed)
            if ($rentedBook->getBook() === $this) {
                $rentedBook->setBook(null);
            }
        }

        return $this;
    }

    public function bookIsRented(): bool
    {
        foreach ($this->rentedBooks as $rentedBook) {
            if (false == $rentedBook->getIsReturned()) {
                return true;
            }
        }

        return false;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }
}
