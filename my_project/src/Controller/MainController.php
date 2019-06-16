<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $userNumber = "";
        if (!empty($request->get('userNumber'))) {
            $userNumber = $request->get('userNumber');
        }
//        if (!empty($_GET["userNumber"])) {
//            $userNumber = $_GET["userNumber"];
//        }
        $randomNumber = rand(0, 10);
        return $this->render('main/index.html.twig', [
            'number' => $randomNumber,
            'userNumber' => $userNumber
        ]);
    }

    /**
     * @Route("/id{id}", requirements={"id"="\d+"})
     */
    public function getProfile($id) {
        return new Response($id);
    }

    /**
     * @Route("/generate/{count}", requirements={"count"="\d+"})
     */
    public function generateNumber($count) {
        $min = pow(10, $count - 1);
        $max = pow(10, $count);

        $randomNumber = rand($min, $max);

        return new Response($randomNumber);
    }
}
