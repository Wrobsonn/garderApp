<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompaniesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ){
    }

    #[Route('/company/index', name: 'company_index')]
    public function companyIndex(Request $request): Response
    {
        $user = $this->getUser();
        if (null === $user->getCompany()) {
            $formCompany = $this->createForm(CompaniesFormType::class, []);

            $formCompany->handleRequest($request);
            if ($formCompany->isSubmitted() && $formCompany->isValid()) {
                $formData = $formCompany->getData();
                $company = Companies::create($formData['company_name']);
                $this->entityManager->persist($company);
                $user->setCompany($company);
                $this->entityManager->flush();

                return $this->redirectToRoute('company_index');
            }

            return $this->render('company/create.html.twig', [
                'formCompany' => $formCompany->createView(),
            ]);
        }

        return $this->render('company/index.html.twig', [
        ]);
    }
}
