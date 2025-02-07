<?php

namespace App\Form;

use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class UserNotCompaniesFormType extends AbstractType
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ){
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = $this->userRepository->findBy(['company' => null]);

        $choices = [];
        foreach ($users as $user) {
            $choices[$user->getUsername()] = $user->getId();
        }

        $builder
            ->add('user_not_company', ChoiceType::class, [
                'required' => true,
                'choices' => $choices,
            ]);
    }
}
