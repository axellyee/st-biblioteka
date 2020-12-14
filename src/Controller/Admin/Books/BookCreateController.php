<?php

namespace App\Controller\Admin\Books;

use App\Entity\Book\Book;
use App\Form\Admin\Book\BookType;
use App\Repository\Book\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookCreateController extends AbstractController
{
    private $manager;
    private $bookRepository;

    public function __construct(EntityManagerInterface $manager, BookRepository $bookRepository)
    {
        $this->manager = $manager;
        $this->bookRepository = $bookRepository;
    }

    /**
     * @Route("/admin/book/create", name="admin_book_create")
     */
    public function __invoke(Request $request): Response
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $randomString = sprintf('%09d', rand(1, 10000000));
            $book->setCode($randomString);

            /** @var UploadedFile $bookImage */
            $bookImage = $form->get('image')->getData();

            if ($bookImage) {
                $originalFilename = pathinfo($bookImage->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$bookImage->guessExtension();

                $bookImage->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $book->setImage($newFilename);
            }

            $this->manager->persist($book);
            $this->manager->flush();

            $this->addFlash('success', 'Grāmata tika izveidota!');

            return $this->redirectToRoute('admin_book_list');
        }

        return $this->render('admin/book/create.html.twig', ['form' => $form->createView(),
            'admin_title' => true, ]);
    }
}
