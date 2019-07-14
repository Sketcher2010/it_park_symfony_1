<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Repository\ChatMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/support", name="chat")
     */
    public function index()
    {
//        $manager = $this->getDoctrine()->getManager();
//        $message = new ChatMessage();
//        $message->setAuthor($this->getUser());
//        $message->setDistenation($this->getUser());
//        $message->setCreatedAt(new \DateTime());
//        $message->setMessage("Test message");
//        $manager->persist($message);
//        $manager->flush();
        return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
        ]);
    }

    /**
     * @Route("/support/get_last_messages", name="get_last_messages")
     * @param Request $request
     * @param ChatMessageRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLastMessages(Request $request, ChatMessageRepository $repository) {
        $lastMessageId = $request->get("lastMessageId");
        $requestCount = 0;
        while($requestCount < 25) {
            $messages = $repository->findLastMessages($lastMessageId, $this->getUser());
            if(count($messages) > 0) {
                return $this->json(["status" => "success", "messages" => $messages]);
            }
            $requestCount++;
            sleep(1);
        }
        return $this->json(["status" => "failed"]);

    }
}
