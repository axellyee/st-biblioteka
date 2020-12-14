<?php

namespace App\Controller\Admin;

use App\Repository\Book\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $bookRepository;
    private $userRepository;

    public function __construct(BookRepository $bookRepository, UserRepository $userRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function __invoke(): Response
    {
        $bookCount = $this->bookRepository->findBy([]);
        $userCount = $this->userRepository->findBy([]);

        $count = [
            'books' => count($bookCount),
            'users' => count($userCount),
        ];

        return $this->render('dashboard.html.twig', [
            'count' => $count,
        ]);
    }
}
