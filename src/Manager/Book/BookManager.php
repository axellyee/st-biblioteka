<?php

namespace App\Manager\Book;

use App\Entity\Book\Book;
use App\Entity\Book\RentedBook;
use App\Entity\User;
use App\Repository\Book\BookRepository;
use App\Repository\Book\RentedBookRepository;
use Doctrine\ORM\EntityManagerInterface;

class BookManager
{
    private $manager;
    private $rentedBookRepository;
    private $bookRepository;

    public function __construct(EntityManagerInterface $manager, RentedBookRepository $rentedBookRepository, BookRepository $bookRepository)
    {
        $this->manager = $manager;
        $this->rentedBookRepository = $rentedBookRepository;
        $this->bookRepository = $bookRepository;
    }

    public function returnBook(Book $book): bool
    {
        /** @var RentedBook $rental */
        $rental = $this->rentedBookRepository->findOneBy(['book' => $book->getId(), 'isReturned' => false]);

        if (null != $rental) {
            $rental->setIsReturned(true);

            $this->manager->persist($rental);
            $this->manager->flush();

            return true;
        }

        throw new \Exception('Grāmata netika atrasta!');
    }

    public function rentBook(Book $book, User $user): bool
    {
        if ($rentedBooks = $book->getRentedBooks()) {
            if (count($rentedBooks) > 0) {
                foreach ($rentedBooks as $rentedBook) {
                    if (false == $rentedBook->getIsReturned()) {
                        return false;
                    }
                }
            }

            $rentalModel = new RentedBook();

            $rentalModel->setBook($book);
            $rentalModel->setUser($user);
            $rentalModel->setIsReturned(false);

            $this->manager->persist($rentalModel);
            $this->manager->flush();

            return true;
        }

        return false;
    }
}
