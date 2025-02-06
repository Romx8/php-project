<?php
// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Redirige vers la landing page (assurez-vous que la route 'app_landing' existe)
        return $this->redirectToRoute('app_landing');
    }
}
