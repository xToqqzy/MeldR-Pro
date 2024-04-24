<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategorieController extends AbstractController
{

    #[Route('/categorie')]
    public function index(CategorieRepository  $categorieRepository, Request $request): Response
    {

        $categorien = $categorieRepository ->findAll();
        return $this->render('categorie/index.html.twig', ["categorien" => $categorien
        ]);

    }
}