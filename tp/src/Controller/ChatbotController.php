<?php

namespace App\Controller;

use App\Service\ChatbotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatbotController extends AbstractController
{
    #[Route('/chatbot', name: 'chatbot', methods: ['POST'])]
    public function index(Request $request, ChatbotService $chatbotService): JsonResponse
    {
        $userMessage = json_decode($request->getContent(), true);

        if (!$userMessage['message']) {
            return new JsonResponse(['error' => 'Message non fourni.'], 400);
        }

        $response = $chatbotService->getResponse($userMessage['message']);
        dd($response);

        return new JsonResponse(['response' => $response]);
    }

    #[Route('/assistant', name: 'app_chatbot')]
    public function chatbot(): Response
    {
        return $this->render('/chatbot/index.html.twig');
    }
}
