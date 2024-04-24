<?php

namespace App\Entity;

use App\Repository\MeldingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MeldingRepository::class)]
class Melding
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    public ?int $melding_id = null;

    #[ORM\ManyToOne(targetEntity: AppUser::class)]
    #[ORM\JoinColumn(name:"user_id")]
    public ?AppUser $user = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    #[ORM\JoinColumn(name:"categorie_id", referencedColumnName: 'id')]
    public ?Categorie $categorie = null;

    #[ORM\Column(type: 'text')]
    public ?string $inhoud = null;


    #[ORM\Column(nullable: true)]
    public ?string $afbeelding_url_eindresultaat = null; // New property for end result picture


    #[ORM\Column(type: 'boolean')]
    public bool $afgehandeld = false; // Added boolean field

    #[ORM\Column(type: 'datetime')]
    public ?\DateTimeInterface $datum_tijd = null;

    #[ORM\Column(nullable: true)]
    public ?string $afbeelding_url = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 8, nullable: true)]
    public ?float $latitude = null;

    #[ORM\Column(type: 'decimal', precision: 11, scale: 8, nullable: true)]
    public ?float $longitude = null;

    // Getter and setter for melding_id
    public function getMeldingId(): ?int
    {
        return $this->melding_id;
    }

    public function setMeldingId(int $melding_id): self
    {
        $this->melding_id = $melding_id;

        return $this;
    }

    // Getter and setter for user_id
    public function getUser(): AppUser
    {
        return $this->user;
    }

    public function setUser(AppUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    //getter and setter for categorie
    public function getCategorie(): ?Categorie{
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): self{
        $this->categorie = $categorie;
        return $this;
    }

    // Getter and setter for afgehandeld
    public function getAfgehandeld(): bool
    {
        return $this->afgehandeld;
    }

    public function setAfgehandeld(bool $afgehandeld): self
    {
        $this->afgehandeld = $afgehandeld;

        return $this;
    }

    // Getter and setter for inhoud
    public function getInhoud(): ?string
    {
        return $this->inhoud;
    }

    public function setInhoud(string $inhoud): self
    {
        $this->inhoud = $inhoud;

        return $this;
    }

    // Getter and setter for datum_tijd
    public function getDatumTijd(): ?\DateTimeInterface
    {
        return $this->datum_tijd;
    }

    public function setDatumTijd(\DateTimeInterface $datum_tijd): self
    {
        $this->datum_tijd = $datum_tijd;

        return $this;
    }

    // Getter and setter for afbeelding_url
    public function getAfbeeldingUrl(): ?string
    {
        return $this->afbeelding_url;
    }

    public function setAfbeeldingUrl(?string $afbeelding_url): self
    {
        $this->afbeelding_url = $afbeelding_url;

        return $this;
    }

    // Getter and setter for latitude
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    // Getter and setter for longitude
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }


    public function getAfbeeldingUrlEindresultaat(): ?string
    {
        return $this->afbeelding_url_eindresultaat;
    }

    public function setAfbeeldingUrlEindresultaat(?string $afbeelding_url_eindresultaat): self
    {
        $this->afbeelding_url_eindresultaat = $afbeelding_url_eindresultaat;

        return $this;
    }




}


