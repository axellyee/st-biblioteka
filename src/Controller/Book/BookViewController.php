<?php

namespace App\Controller\Book;

use App\Entity\Book\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookViewController extends AbstractController
{
    /**
     * @Route("/book/{book}", name="book_view")
     */
    public function __invoke(Book $book): Response
    {
        return $this->render('book/view.html.twig', [
            'book' => $book,
        ]);
    }
}
