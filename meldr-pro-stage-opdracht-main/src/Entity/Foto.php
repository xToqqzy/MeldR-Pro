<?php

namespace App\Entity;

use App\Repository\FotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FotoRepository::class)]
class Foto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $foto_id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datum_tijd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFotoId(): ?int
    {
        return $this->foto_id;
    }

    public function setFotoId(int $foto_id): static
    {
        $this->foto_id = $foto_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getDatumTijd(): ?\DateTimeInterface
    {
        return $this->datum_tijd;
    }

    public function setDatumTijd(\DateTimeInterface $datum_tijd): static
    {
        $this->datum_tijd = $datum_tijd;

        return $this;
    }
}
