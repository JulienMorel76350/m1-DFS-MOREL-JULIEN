<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Check if the user is authenticated
        if (!$this->getUser()) {
            // Redirect to login page if not authenticated
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('home/index.html.twig');
    }
}
