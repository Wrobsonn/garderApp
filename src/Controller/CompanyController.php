<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompaniesFormType;
use App\Form\UserNotCompaniesFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
    ){
    }

    #[Route('/company/index', name: 'company_index')]
    public function companyIndex(Request $request): Response
    {
        $user = $this->getUser();
        $company = $user->getCompany();
        if (null === $company) {
            $formCompany = $this->createForm(CompaniesFormType::class, []);

            $formCompany->handleRequest($request);
            if ($formCompany->isSubmitted() && $formCompany->isValid()) {
                $formData = $formCompany->getData();
                $newCompany = Companies::create($formData['company_name']);
                $this->entityManager->persist($newCompany);
                $user->setCompany($newCompany);
                $this->entityManager->flush();

                return $this->redirectToRoute('company_index');
            }

            return $this->render('company/create.html.twig', [
                'formCompany' => $formCompany->createView(),
            ]);
        }

        $formNotCompanyUser = $this->createForm(UserNotCompaniesFormType::class, []);

        $formNotCompanyUser->handleRequest($request);
        if ($formNotCompanyUser->isSubmitted() && $formNotCompanyUser->isValid()) {
            $formData = $formNotCompanyUser->getData();
            $notCompanyUser = $this->userRepository->find( $formData['user_not_company']);
            $notCompanyUser->setCompany($company);
            $this->entityManager->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('company/index.html.twig', [
            'company' => $company,
            'companyUsers' => $company->getUsers(),
            'formNotCompanyUser' => $formNotCompanyUser->createView(),
        ]);
    }
}
