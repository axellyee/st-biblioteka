<?php

namespace App\Controller\Admin\Books;

use App\Entity\Book\Book;
use App\Manager\Book\BookManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookReturnController extends AbstractController
{
    private $bookManager;

    public function __construct(BookManager $bookManager)
    {
        $this->bookManager = $bookManager;
    }

    /**
     * @Route("/admin/book/{book}/return", name="admin_book_return")
     */
    public function __invoke(Book $book): Response
    {
        try {
            $this->bookManager->returnBook($book);
        } catch (\Exception $exception) {
            $this->addFlash('danger', $exception->getMessage());
        }

        return $this->redirectToRoute('admin_book_list');
    }
}
