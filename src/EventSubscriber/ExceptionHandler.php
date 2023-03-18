<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionHandler
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['process', 0],
                ['log', 1],
            ],
        ];
    }

    public function process(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpException) {
            $response = new JsonResponse([
                'error' => $exception->getMessage(),
            ]);
            $response->setStatusCode(Response::HTTP_I_AM_A_TEAPOT);
            $response->headers->set('Real-Status-Code', $exception->getStatusCode());
            $event->setResponse($response);
        }
    }

    public function log(ExceptionEvent $event)
    {
        $response = $event->getResponse();
        if ($response && ($response->getStatusCode() === Response::HTTP_I_AM_A_TEAPOT)) {
            $this->logger->critical('ACHTUNG!!!', [
                'message' => $event->getThrowable()->getMessage(),
                'status' => $response->headers->get('Real-Status-Code'),
            ]);
        }
    }
}
