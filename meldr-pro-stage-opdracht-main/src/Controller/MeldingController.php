<?php

namespace App\Controller;

use App\Entity\Melding;
use App\Form\MeldingAfhandelType;
use App\Form\MeldingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/melding')]
class MeldingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/toevoegen', name: 'melding_toevoegen')]
    public function toevoegen(Request $request): Response
    {
        // Maak een nieuwe melding entiteit aan
        $melding = new Melding();
        // Stel een unieke ID in voor de melding
        $melding->setMeldingId((int)uniqid());
        // Gebruik de ingelogde gebruiker als de eigenaar van de melding
        $melding->setUser($this->getUser());
        // Stel de huidige datum en tijd in voor de melding
        $melding->setDatumTijd(new \DateTime());

        // Maak een formulier voor het toevoegen van meldingen
        $form = $this->createForm(MeldingType::class, $melding);
        $form->handleRequest($request);

        // Verwerk het ingediende formulier
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $afbeeldingFile */
            $afbeeldingFile = $form->get('afbeelding')->getData();

            // Verwerk de geüploade afbeelding
            if ($afbeeldingFile) {
                // Genereer een unieke bestandsnaam
                $nieuweBestandsnaam = uniqid().'.'.$afbeeldingFile->getClientOriginalExtension();
                // Verplaats het bestand naar de gewenste map
                $afbeeldingFile->move(
                    $this->getParameter('afbeeldingen_directory'),
                    $nieuweBestandsnaam
                );
                // Werk de entiteit bij met de URL van de afbeelding
                $melding->setAfbeeldingUrl($nieuweBestandsnaam);
            }



            // Sla de melding op in de database
            $this->entityManager->persist($melding);
            $this->entityManager->flush();

            // Stuur de gebruiker door naar de bevestigingspagina
            return $this->redirectToRoute('melding_bevestiging', ['id' => $melding->getMeldingId()]);
        }

        // Toon het formulier voor het toevoegen van meldingen
        return $this->render('melding/toevoegen.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/bevestiging/{id}', name: 'melding_bevestiging')]
    public function bevestiging($id): Response
    {
        // Zoek de melding in de database op basis van de ID
        $melding = $this->entityManager->getRepository(Melding::class)->findOneBy(['melding_id' => $id]);

        // Controleer of de melding bestaat
        if (!$melding) {
            // Gooi een 404 Not Found uitzondering als de melding niet bestaat
            throw $this->createNotFoundException('Deze melding bestaat niet');
        }

        // Toon de bevestigingspagina met de meldingsdetails
        return $this->render('melding/bevestiging.html.twig', [
            'melding' => $melding,
        ]);
    }

    #[Route('/mijn-meldingen', name: 'mijn_meldingen')]
    public function mijnMeldingen(): Response
    {
        // Haal de huidige gebruiker op
        $currentUser = $this->getUser();
        // Zoek alle meldingen van de huidige gebruiker in de database
        $meldingen = $this->entityManager->getRepository(Melding::class)->findBy(['user' => $currentUser]);

        // Toon de pagina met meldingen van de huidige gebruiker
        return $this->render('melding/mijn_meldingen.html.twig', [
            'meldingen' => $meldingen,
        ]);
    }

    #[Route('/meldingen-overzicht', name: 'meldingen_overzicht')]
    public function overzicht(Request $request): Response
    {
        // Haal alle meldingen op uit de database
        $meldingen = $this->entityManager->getRepository(Melding::class)->findAll();

        // Toon een overzichtspagina met alle meldingen
        return $this->render('melding/index.html.twig', [
            'meldingen' => $meldingen,
        ]);
    }

    #[Route('/details/{id}', name: 'melding_details')]
    public function details($id, Request $request): Response
    {




        // Zoek de melding in de database op basis van de ID
        $melding = $this->entityManager->getRepository(Melding::class)->find($id);



        // Controleer of de melding bestaat
        if (!$melding) {
            // Gooi een 404 Not Found uitzondering als de melding niet bestaat
            throw $this->createNotFoundException('Deze melding bestaat niet');


        }



        $form = $this->createForm(MeldingAfhandelType::class, $melding);
        $form->handleRequest($request);

        // Verwerk het ingediende formulier
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $afbeeldingFile */
            $afbeeldingFile = $form->get('afbeelding_url_eindresultaat')->getData();

            // Verwerk de geüploade afbeelding
            if ($afbeeldingFile) {
                // Genereer een unieke bestandsnaam
                $nieuweBestandsnaam = uniqid().'.'.$afbeeldingFile->getClientOriginalExtension();
                // Verplaats het bestand naar de gewenste map
                $afbeeldingFile->move(
                    $this->getParameter('afbeeldingen_directory'),
                    $nieuweBestandsnaam
                );
                // Werk de entiteit bij met de URL van de afbeelding
                $melding->setAfbeeldingUrlEindresultaat($nieuweBestandsnaam);
            }

            $melding->setAfgehandeld(true);




            // Sla de melding op in de database
            $this->entityManager->flush();

            // Stuur de gebruiker door naar de bevestigingspagina
            return $this->redirectToRoute('melding_details', ['id' => $melding->getMeldingId()]);
        }




        // Toon de detailpagina van de melding
        return $this->render('melding/meldingdetails.html.twig', [
            'melding' => $melding, 'form' => $form->createView()
        ]);
    }

    #[Route('/afhandelen/{id}', name: 'melding_afhandelen')]
    public function afhandelen($id): Response
    {
        // Zoek de melding in de database op basis van de ID
        $melding = $this->entityManager->getRepository(Melding::class)->find($id);

        // Controleer of de melding bestaat
        if (!$melding) {
            // Gooi een 404 Not Found uitzondering als de melding niet bestaat
            throw $this->createNotFoundException('Deze melding bestaat niet');
        }

        // Markeer de melding als afgehandeld door de afgehandeld-vlag op true in te stellen
        $melding->setAfgehandeld(true);

        // Sla de wijzigingen op in de database
        $this->entityManager->flush();

        // Nadat de melding is afgehandeld, leid de gebruiker om naar de detailspagina van de melding
        return $this->redirectToRoute('melding_details', ['id' => $melding->getMeldingId()]);
    }
}
