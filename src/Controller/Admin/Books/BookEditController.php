<?php

namespace App\Controller\Admin\Books;

use App\Entity\Book\Book;
use App\Form\Admin\Book\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookEditController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin/book/{book}/edit", name="admin_book_edit")
     */
    public function __invoke(Book $book, Request $request): Response
    {
        $form = $this->createForm(BookType::class, $book)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ?UploadedFile $bookImage */
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

            $this->addFlash('success', 'Grāmatas informāciija tika atjaunota!');

            return $this->redirectToRoute('admin_book_list');
        }

        return $this->render('admin/book/edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book,
            'admin_title' => true,
        ]);
    }
}
