<?php

namespace App\Form;

use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignedWorkFormType extends AbstractType
{
    public function __construct(
        private readonly JobRepository $jobRepository,
        private readonly UserRepository $userRepository,
    ){
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $jobs = $this->jobRepository->findBy(['company' => $options['company']]);
        $users = $this->userRepository->findBy(['company' => $options['company']]);

        $choicesJobs = [];
        foreach ($jobs as $job) {
            $choicesJobs[$job->getName()] = $job->getId();
        }

        $choicesUser = [];
        foreach ($users as $user) {
            $choicesUser[$user->getUsername()] = $user->getId();
        }

        $builder
            ->add('hour', NumberType::class, [
                'required' => true,
            ])
            ->add('minute', NumberType::class, [
                'required' => true,
            ])
            ->add('job', ChoiceType::class, [
                'required' => true,
                'choices' => $choicesJobs,
            ])
            ->add('user', ChoiceType::class, [
                'required' => true,
                'choices' => $choicesUser,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'company' => null,
        ]);
    }
}
