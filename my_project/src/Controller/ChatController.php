<?php

namespace App\Controller;

use App\Entity\ChatMessage;
use App\Entity\ShopUser;
use App\Repository\ChatMessageRepository;
use App\Repository\ShopUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/support", name="chat")
     */
    public function index()
    {
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

    /**
     * @Route("/support/send_message", name="send_message")
     * @param Request $request
     * @param ShopUserRepository $repository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function sendMessage(Request $request, ShopUserRepository $repository) {
        $author = $this->getUser();
        $distenation = $repository->find($request->request->get("distenation"));
        $message = $request->request->get("message");
        $time = new \DateTime();
        $manager = $this->getDoctrine()->getManager();

        $newMessage = new ChatMessage();
        $newMessage->setMessage($message);
        $newMessage->setAuthor($author);
        $newMessage->setDistenation($distenation);
        $newMessage->setCreatedAt($time);

        $manager->persist($newMessage);
        $manager->flush();

        return $this->json(["status" => "success"]);
    }
}
