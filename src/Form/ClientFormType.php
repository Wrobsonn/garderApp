<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client_name', TextType::class, [
                'required' => true,
            ]) ->add('company_name', TextType::class, [
                'required' => false,
            ])
            ->add('nip', TextType::class, [
                'required' => false,
            ])
            ->add('post_code', TextType::class, [
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'required' => true,
            ])
            ->add('street', TextType::class, [
                'required' => true,
            ]);
    }
}
