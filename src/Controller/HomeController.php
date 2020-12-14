<?php

namespace App\Controller;

use App\Repository\Book\BookRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $bookRepository;
    private $paginator;

    public function __construct(BookRepository $bookRepository, PaginatorInterface $paginator)
    {
        $this->bookRepository = $bookRepository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/", name="home")
     */
    public function __invoke(Request $request): Response
    {
        if ($request->get('search')) {
            $books = $this->bookRepository->findBySearch($request->get('search'));
        } else {
            $books = $this->bookRepository->findBy([]);
        }

        $paginatedBooks = $this->paginator->paginate($books, $request->query->getInt('page', 1), 9);

        return $this->render('home.html.twig', [
            'books' => $paginatedBooks,
        ]);
    }
}
