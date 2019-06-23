<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\ShopUser;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class BookController extends AbstractController
{
    /**
     * @Route("/books/{book}", requirements={"book"="\d+"}, name="book_page")
     * @param Book $book
     * @return Response
     */
    public function getBook(Book $book)
    {
        return $this->render(
            'book/book.html.twig',
            ["book" => $book]
        );
    }

    /**
     * @Route("/", name="books_list")
     */
    public function bookList()
    {
        $repository = $this
            ->getDoctrine()
            ->getRepository(Book::class);
        $books = $repository->findAll();

        return $this->render(
            'book/list.html.twig',
            ["books" => $books]
        );
    }

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
     * @IsGranted("ROLE_ADMIN_USER")
     * @Route("/books/create", name="book_create")
     * @param Request $request
     * @return Response
     */
    public function createBook(Request $request)
    {
        $book = new Book();
        $form = $this
            ->createFormBuilder($book)
            ->add('title', TextType::class, [
                'required' => true,
                'label' => 'Название книги',
                'attr' => [
                    'placeholder' => 'Моя книга 1'
                ]
            ])
            ->add('author', EntityType::class, [
                'label' => "Автор",
                'required' => true,
                'class' => ShopUser::class,
                'choice_label' => 'email'
            ])
            ->add('pages_count', IntegerType::class, [
                'required' => true,
                'label' => 'Количество страниц книги',
                'attr' => [
                    'placeholder' => '999'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => 'Стоимость книги',
                'attr' => [
                    'placeholder' => '500'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => "Сохарнить"
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();
            return new RedirectResponse('/');
        }

        return $this->render(
            'book/create.html.twig',
            ["form" => $form->createView()]
        );
    }
}
