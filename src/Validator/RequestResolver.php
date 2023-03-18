<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ArgumentValueResolverInterface
{
    /** @var SerializerInterface */
    private $serializer;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return 0 === strpos($argument->getType(), __NAMESPACE__);
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $content = empty($request->getContent()) ? '{}' : $request->getContent();

        try {
            $validatedRequest = $this->serializer->deserialize($content, $argument->getType(), 'json');
        } catch (\Exception $e) {
            throw new BadRequestHttpException('Ошибка параметров.');
        }

        $validatedRequest->setRequest($request);
        $this->validate($validatedRequest);

        yield $validatedRequest;
    }

    protected function validate($validatedRequest): void
    {
        $violations = $this->validator->validate($validatedRequest);
        if ($violations->count() !== 0) {
            $errorMessages = [];
            foreach ($violations as $violation) {
                if (!isset($errorMessages[$violation->getPropertyPath()])) {
                    $errorMessages[$violation->getPropertyPath()] = $violation->getPropertyPath() . ':';
                }
                $errorMessages[$violation->getPropertyPath()] .= ' ' . $violation->getMessage();
            }

            throw new BadRequestHttpException(
                "Некорректные параметры:\n"
                . implode("\n", $errorMessages)
            );
        }
    }
}
