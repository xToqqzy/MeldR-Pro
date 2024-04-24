<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class FotoController extends AbstractController
{
    #[Route('/foto', name: 'app_foto')]
    public function index(Request $request): Response
    {
        return $this->render('foto/index.html.twig');
    }
}