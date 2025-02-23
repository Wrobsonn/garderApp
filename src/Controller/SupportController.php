<?php

namespace App\Controller;

use App\Entity\Support;
use App\Entity\SupportMessage;
use App\Form\SupportFormType;
use App\Form\SupportMessageFormType;
use App\Repository\SupportMessageRepository;
use App\Repository\SupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly SupportRepository $supportRepository,
        private readonly SupportMessageRepository $supportMessageRepository,
    ){
    }

    #[Route('/support/index', name: 'support_index')]
    public function supportIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $supports = $this->supportRepository->findBy([
            'company' => $company,
        ]);

        return $this->render('support/index.html.twig', [
            'supports' => $supports,
        ]);
    }

    #[Route('/support/add', name: 'support_add')]
    public function addSupport(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $formCreateSupport = $this->createForm(SupportFormType::class, []);

        $formCreateSupport->handleRequest($request);
        if ($formCreateSupport->isSubmitted() && $formCreateSupport->isValid()) {
            $formData = $formCreateSupport->getData();
            $support = Support::create(
                $formData['name'],
                $formData['contents'],
                $user,
                $company,
            );

            $this->entityManager->persist($support);
            $this->entityManager->flush();

            return $this->redirectToRoute('support_index');
        }

        return $this->render('support/add_support.html.twig', [
            'formCreateSupport' => $formCreateSupport->createView(),
        ]);
    }

    #[Route('/support_message/add/{id}', name: 'support_message_add')]
    public function addSupportMessage(Request $request, int $id): Response
    {
        $user = $this->getUser();

        $formCreateSupportMessage = $this->createForm(SupportMessageFormType::class, []);

        $formCreateSupportMessage->handleRequest($request);
        if ($formCreateSupportMessage->isSubmitted() && $formCreateSupportMessage->isValid()) {
            $formData = $formCreateSupportMessage->getData();
            $supportMessage = SupportMessage::create(
                $formData['contents'],
                $user,
                $this->supportRepository->find($id),
            );

            $this->entityManager->persist($supportMessage);
            $this->entityManager->flush();

            return $this->redirectToRoute('support_index');
        }

        return $this->render('support/add_support_message.html.twig', [
            'comments' => $this->supportMessageRepository->findBy([
                'support' => $this->supportRepository->find($id),
            ]),
            'formCreateSupportMessage' => $formCreateSupportMessage->createView(),
            'id' => $id,
        ]);
    }
}
