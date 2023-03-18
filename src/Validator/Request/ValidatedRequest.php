<?php

namespace App\Validator\Request;

use Symfony\Component\HttpFoundation\Request;

abstract class ValidatedRequest
{
    /** @var Request */
    private $request;

    public function __construct()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
        }
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }
}
