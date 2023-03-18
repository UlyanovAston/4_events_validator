<?php

namespace App\Controller;

use App\Form\BookFormData;
use App\Form\BookType;
use App\Validator\Request\BookRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidationsController extends AbstractController
{
    public function form(Request $request): JsonResponse
    {
        $bookData = new BookFormData();
        $form = $this->createForm(BookType::class, $bookData);

        if (!$form->isSubmitted()) {
            $form->submit($request->toArray());
        }

        if (!$form->isValid()) {
            throw new BadRequestHttpException(
                json_encode($this->getErrorMessages($form))
            );
        }

        return $this->json([
            'message' => $bookData->getName() . ' registered!',
        ]);
    }

    public function request(BookRequest $request): JsonResponse
    {
        return $this->json([
            'message' => $request->getName() . ' registered!',
        ]);
    }

    private function getErrorMessages(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
