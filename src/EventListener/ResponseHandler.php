<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseHandler
{
    public function setStupidHeaders(JsonResponse $response)
    {
        $response->headers->set('cat', 'meow');
        $response->headers->set('dog', 'woof');
        $response->headers->set('fox', 'wtf');
    }
}
