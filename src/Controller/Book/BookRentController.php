<?php

namespace App\Controller\Book;

use App\Entity\Book\Book;
use App\Entity\User;
use App\Manager\Book\BookManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookRentController extends AbstractController
{
    private $bookManager;

    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/book/{book}/rent", name="book_rent")
     */
    public function __invoke(Book $book): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        try {
            $this->bookManager->rentBook($book, $user);
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->redirectToRoute('my_dashboard');
    }
}
