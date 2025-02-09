<?php

namespace App\Controller;

use App\Entity\AssignedWork;
use App\Form\AssignedWorkFormType;
use App\Repository\AssignedWorkRepository;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssignedWorkController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AssignedWorkRepository $assignedWorkRepository,
        private readonly JobRepository $jobRepository,
    ){
    }

    #[Route('/assigned_work/index', name: 'assigned_work_index')]
    public function assignedWorkIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $assignedWorks = $this->assignedWorkRepository->findBy([
            'company' => $company,
        ]);

        return $this->render('assigned_work/index.html.twig', [
            'assignedWorks' => $assignedWorks,
        ]);
    }

    #[Route('/assigned_work/add', name: 'assigned_work_add')]
    public function addAssignedWork(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $formCreateAssignedWork = $this->createForm(AssignedWorkFormType::class, [],[
            'company' => $company,
        ]);

        $formCreateAssignedWork->handleRequest($request);
        if ($formCreateAssignedWork->isSubmitted() && $formCreateAssignedWork->isValid()) {
            $formData = $formCreateAssignedWork->getData();
            $job = $this->jobRepository->find($formData['job']);
            $assignedWork = AssignedWork::create(
                $formData['hour'],
                $formData['minute'],
                $job,
                $company,
            );

            $this->entityManager->persist($assignedWork);
            $this->entityManager->flush();

            return $this->redirectToRoute('assigned_work_index');
        }

        return $this->render('assigned_work/add_assigned_work.html.twig', [
            'formCreateAssignedWork' => $formCreateAssignedWork->createView(),
        ]);
    }
}
