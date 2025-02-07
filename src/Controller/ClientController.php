<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ClientRepository $clientRepository,
    ){
    }

    #[Route('/client/index', name: 'client_index')]
    public function companyIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $clients = $this->clientRepository->findBy([
            'company' => $company,
        ]);

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/client/add', name: 'client_add')]
    public function addClient(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();

        $formCreateClient = $this->createForm(ClientFormType::class, []);

        $formCreateClient->handleRequest($request);
        if ($formCreateClient->isSubmitted() && $formCreateClient->isValid()) {
            $formData = $formCreateClient->getData();
            $client = Client::create(
                $formData['client_name'],
                $formData['company_name'],
                $formData['nip'],
                $formData['post_code'],
                $formData['city'],
                $formData['street'],
                $company,
            );

            $this->entityManager->persist($client);
            $this->entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/add_client.html.twig', [
            'formCreateClient' => $formCreateClient->createView(),
        ]);
    }
}
