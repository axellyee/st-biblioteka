<?php

namespace App\Controller\My;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyDashboardController extends AbstractController
{
    /**
     * @Route("/my/dashboard", name="my_dashboard")
     */
    public function __invoke(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $bookRentals = $user->getRentedBooks();

        return $this->render('my/dashboard.html.twig', [
            'bookRentals' => $bookRentals,
        ]);
    }
}
