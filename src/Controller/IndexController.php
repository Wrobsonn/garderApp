<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (null === $user){
            return $this->render('index/index_not_login.html.twig', [
            ]);
        }

        return $this->render('index/index_login.html.twig', [
            'user' => $user,
        ]);
    }
}
