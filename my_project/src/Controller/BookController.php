<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/books/create", name="book_create")
     */
    public function createBook() {
        $manager = $this->getDoctrine()->getManager();

        $book = new Book();
        $book->setTitle("Автостопом по галактике");
        $book->setPagesCount(380);

        $manager->persist($book);
        $manager->flush();

        return new Response($book->getId());
    }
}
