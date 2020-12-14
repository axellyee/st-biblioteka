<?php

namespace App\Controller\Admin\Books;

use App\Entity\Book\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookDeleteController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/book/{book}/delete", name="admin_book_delete")
     */
    public function __invoke(Book $book): Response
    {
        $this->manager->remove($book);
        $this->manager->flush();

        $this->addFlash('success', 'Grāmata tika izdzēsta!');

        return $this->redirectToRoute('admin_book_list', [
            'admin_title' => true,
        ]);
    }
}
