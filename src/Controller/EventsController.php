<?php

namespace App\Controller;

use App\Service\RequestTypeGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EventsController extends AbstractController
{
    public function one(Request $request): JsonResponse
    {
        $requestType = $request->attributes->get('type');
        $message = $requestType === RequestTypeGenerator::REQUEST_TYPE_ONE ? 'your lucky!' : 'its ok';

        return $this->json([
            'message' => $message,
        ]);
    }

    public function two(): JsonResponse
    {
        $response = $this->json([
            'message' => 'ping',
        ]);

        $this->setStupidHeaders($response);

        return $response;
    }

    public function three(): JsonResponse
    {
        $response = $this->json([
            'message' => 'pong',
        ]);

        $this->setStupidHeaders($response);

        return $response;
    }

    public function four(): JsonResponse
    {
        throw new BadRequestHttpException("I'M A TEAPOT!!!");
    }

    private function setStupidHeaders(JsonResponse $response)
    {
        $response->headers->set('cat', 'meow');
        $response->headers->set('dog', 'woof');
        $response->headers->set('fox', 'wtf');
    }
}
