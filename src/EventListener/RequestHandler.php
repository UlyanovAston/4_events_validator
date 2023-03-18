<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequestHandler
{
    const ALLOWED_IP = '8.8.8.8';

    public function checkClientIp(RequestEvent $event)
    {
        if ($event->getRequest()->getClientIp() !== self::ALLOWED_IP) {
            throw new AccessDeniedHttpException();
        }
    }
}
