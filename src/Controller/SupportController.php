<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Support;
use App\Entity\Tool;
use App\Form\CompaniesFormType;
use App\Form\SupportFormType;
use App\Form\ToolFormType;
use App\Form\UserNotCompaniesFormType;
use App\Repository\SupportRepository;
use App\Repository\ToolRepository;
use App\Repository\UserRepository;
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
        private readonly UserRepository $userRepository,
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
            $tool = Support::create(
                $formData['name'],
                $formData['contents'],
                $user,
                $company,
            );

            $this->entityManager->persist($tool);
            $this->entityManager->flush();

            return $this->redirectToRoute('support_index');
        }

        return $this->render('support/add_support.html.twig', [
            'formCreateSupport' => $formCreateSupport->createView(),
        ]);
    }
}
