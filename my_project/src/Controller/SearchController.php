<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param BookRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, BookRepository $repository)
    {
        return $this->json($repository->findLike($request->get("q")));
    }
}
