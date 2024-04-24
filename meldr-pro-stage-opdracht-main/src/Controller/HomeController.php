<?php

// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\MeldingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
private $meldingRepository;

public function __construct(MeldingRepository $meldingRepository)
{
$this->meldingRepository = $meldingRepository;
}

/**
* @Route("/", name="home")
*/
public function index(): Response
{
// Haal de meldingen op uit de repository
$meldingen = $this->meldingRepository->findAll();

// Render de Twig-sjabloon voor de homepagina en geef de meldingen door als variabele
return $this->render('security/home.html.twig', [
'meldingen' => $meldingen,
]);
}
}
