<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\App\Form\Journal;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class EntryFormType.
 *
 * @package CoolStuff\App\Form\Journal
 */
final class EntryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Item Entry #',
                'attr' => [
                    'value' => date('y').date('m').date('d').'-'.rand(0000, 9000),
                    'disabled' => true,
                ],
            ])
            ->add('date_created', DateType::class, [
                'label' => 'Date created',
                'html5' => false,
            ])
            ->add('product', ChoiceType::class, [
                'label' => 'Select product',
                'choices' => $options['products'],
                'choice_label' => 'getName',
                'choice_value' => 'getId',
                'expanded' => false,
            ])
            ->add('active_units', NumberType::class, [
                'label' => 'Active units',
            ])
            ->add('stock_on_hand', NumberType::class, [
                'label' => 'Stock on Hand',
            ])
            ->add('note', TextareaType::class);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);

        parent::buildForm($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'products' => [],
        ]);

        parent::configureOptions($resolver);
    }

    public function onPreSetData(FormEvent $event)
    {
    }
}
