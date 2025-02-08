<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Entity\Tool;
use App\Form\CompaniesFormType;
use App\Form\ToolFormType;
use App\Form\UserNotCompaniesFormType;
use App\Repository\ToolRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToolController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ToolRepository $toolRepository,
    ){
    }

    #[Route('/tool/index', name: 'tool_index')]
    public function toolIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $tools = $this->toolRepository->findBy([
            'company' => $company,
        ]);

        return $this->render('tool/index.html.twig', [
            'tools' => $tools,
        ]);
    }

    #[Route('/tool/add', name: 'tool_add')]
    public function addTool(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $formCreateTool = $this->createForm(ToolFormType::class, []);

        $formCreateTool->handleRequest($request);
        if ($formCreateTool->isSubmitted() && $formCreateTool->isValid()) {
            $formData = $formCreateTool->getData();
            $tool = Tool::create(
                $formData['name'],
                $company,
            );

            $this->entityManager->persist($tool);
            $this->entityManager->flush();

            return $this->redirectToRoute('tool_index');
        }

        return $this->render('tool/add_tool.html.twig', [
            'formCreateTool' => $formCreateTool->createView(),
        ]);
    }
}
