<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Entity\ShopUser;
use App\Repository\ChatMessageRepository;
use App\Repository\ShopUserRepository;
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
     * @Route("/support/users", name="support_users")
     * @param ShopUserRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getUsersList(ShopUserRepository $repository) {
        $users = $repository->findAll();
        return $this->render('chat/users.html.twig', [
            "users" => $users,
            "currentUserId" => $this->getUser()->getId()
        ]);
    }

    /**
     * @Route("/support/chat/{user}", requirements={"user"="\d+"}, name="chat_with_user", )
     * @param ShopUser $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getChatWithUser(ShopUser $user) {
        return $this->render('chat/chatWithUser.html.twig', [
            'destination' => $user
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

    /**
     * @Route("/support/get_messages_with_user/{user}.json", requirements={"user"="\d+"}, name="get_messages_with_user")
     * @param ShopUser $user
     * @param Request $request
     * @param ChatMessageRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLastMessagesWithUser(ShopUser $user, Request $request, ChatMessageRepository $repository) {
        $lastMessageId = $request->get("lastMessageId");
        $requestCount = 0;
        while($requestCount < 25) {
            $messages = $repository->findLastMessagesWithUser($lastMessageId, $user, $this->getUser());
            if(count($messages) > 0) {
                return $this->json(["status" => "success", "messages" => $messages]);
            }
            $requestCount++;
            sleep(1);
        }
        return $this->json(["status" => "failed"]);

    }
}
