<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace CoolStuff\App\Form\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class ViewFormType.
 *
 * @package CoolStuff\Module\App\Form\Product
 */
final class ViewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Enter Product name',
                    'disabled' => true,
                ],
            ])
            ->add('tagline', TextType::class, [
                'label' => 'Tagline',
                'attr' => [
                    'placeholder' => 'Enter Product tagline',
                    'disabled' => true,
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'disabled' => true,
                ],
            ])
            ->add('brand', TextType::class, [
                'label' => 'Brand',
                'attr' => [
                    'placeholder' => 'Enter Product name',
                    'disabled' => true,
                ],
            ])
            ->add('is_active', CheckboxType::class, [
                'label' => 'Active',
                'attr' => [
                    'disabled' => true,
                ],
            ]);

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }
}
