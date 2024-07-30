<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VacationController extends AbstractController
{
    #[Route('/vacation', name: 'app_vacation')]
    public function index(): Response
    {
        return $this->render('vacation/index.html.twig', [
            'controller_name' => 'VacationController',
        ]);
    }
}
