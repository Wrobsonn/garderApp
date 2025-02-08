<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobFormType;
use App\Repository\ClientRepository;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly JobRepository $jobRepository,
        private readonly ClientRepository $clientRepository,
    ){
    }

    #[Route('/job/index', name: 'job_index')]
    public function toolIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $jobs = $this->jobRepository->findBy([
            'company' => $company,
        ]);

        return $this->render('job/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    #[Route('/job/add', name: 'job_add')]
    public function addJob(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $formCreateJob = $this->createForm(JobFormType::class, [], [
            'company' => $company,
        ]);

        $formCreateJob->handleRequest($request);
        if ($formCreateJob->isSubmitted() && $formCreateJob->isValid()) {
            $formData = $formCreateJob->getData();
            $client = $this->clientRepository->find($formData['client_name']);

            $tool = Job::create(
                $formData['job_name'],
                $company,
                $formData['tools'],
                $client,
            );

            $this->entityManager->persist($tool);
            $this->entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/add_job.html.twig', [
            'formCreateJob' => $formCreateJob->createView(),
        ]);
    }
}
