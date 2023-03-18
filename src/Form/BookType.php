<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class BookType extends AbstractType
{
    const DEFAULT_PAGE_COUNT = 400;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod(Request::METHOD_POST)
            ->add(
                'name',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'page_count',
                TextType::class,
                [
                    'constraints' => [
                        new Type(['type' => 'digit']),
                        new Range(['min' => 1, 'max' => 5000]),
                    ],
                    'empty_data' => self::DEFAULT_PAGE_COUNT,
                ]
            )
            ->add(
                'is_active',
                CheckboxType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );
    }
}
