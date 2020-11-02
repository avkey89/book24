<?php

namespace App\Controller;

use App\Services\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/message-send", name="message_send")
     * @param MessageService $messageService
     * @return JsonResponse
     */
    public function messageSend(MessageService $messageService): JsonResponse
    {
        $messages = [
            [
                "firm_id" => 1,
                "subject" => "S1",
                "body" => "B1",
                "from" => "F1",
                "to" => "T1"
            ],
            [
                "firm_id" => 2,
                "subject" => "S2",
                "body" => "B2",
                "from" => "F2",
                "to" => "T2"
            ],
            [
                "firm_id" => 3,
                "subject" => "S3",
                "body" => "B3",
                "from" => "F3",
                "to" => "T3"
            ],
            [
                "firm_id" => 1,
                "subject" => "S1.1",
                "body" => "B1.1",
                "from" => "F1.1",
                "to" => "T1.1"
            ],
            [
                "firm_id" => 5,
                "subject" => "S5",
                "body" => "B5",
                "from" => "F5",
                "to" => "T5"
            ],
        ];

        $messageService->run($messages);

        return $this->json([]);
    }

    /**
     * @Route("/", name="home")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/WelcomeController.php',
        ]);
    }
}
