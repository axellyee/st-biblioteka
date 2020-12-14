<?php

namespace App\Controller\Admin\Books;

use App\Repository\Book\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookListController extends AbstractController
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/admin/book/list", name="admin_book_list")
     */
    public function __invoke(): Response
    {
        $books = $this->bookRepository->findBy([]);

        return $this->render('admin/book/list.html.twig', [
            'books' => $books,
            'admin_title' => true,
        ]);
    }
}
