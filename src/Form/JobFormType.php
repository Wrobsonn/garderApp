<?php

namespace App\Form;

use App\Repository\ClientRepository;
use App\Repository\ToolRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobFormType extends AbstractType
{
    public function __construct(
        private readonly ToolRepository $toolRepository,
        private readonly ClientRepository $clientRepository,
    ){
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $clients = $this->clientRepository->findBy(['company' => $options['company']]);
        $tools = $this->toolRepository->findBy(['company' => $options['company']]);

        $choicesClient = [];
        foreach ($clients as $client) {
            $choicesClient[$client->getClientName()] = $client->getId();
        }

        $choicesTool = [];
        foreach ($tools as $tool) {
            $choicesTool[$tool->getName()] = $tool->getId();
        }

        $builder
            ->add('job_name', TextType::class, [
                'required' => true,
            ])
            ->add('client_name', ChoiceType::class, [
                'required' => false,
                'choices' => $choicesClient,
            ])
            ->add('tools', ChoiceType::class, [
                'required' => false,
                'choices' => $choicesTool,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'company' => null,
        ]);
    }
}
