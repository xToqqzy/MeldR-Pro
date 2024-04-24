<?php

// src/Entity/AppUser.php

namespace App\Entity;

use App\Repository\AppUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AppUserRepository::class)]
class AppUser implements UserInterface, PasswordAuthenticatedUserInterface
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;

#[ORM\Column(length: 255)]
private ?string $username = null;

#[ORM\Column(length: 255, nullable: true)]
private ?string $password = null;

#[ORM\Column(length: 255)]
private ?string $givenName = null;

#[ORM\Column(length: 255)]
private ?string $email = null; // New property for email address

// Getter and setter for id

public function getId(): ?int
{
return $this->id;
}

// Getter and setter for username

public function getUsername(): ?string
{
return $this->username;
}

public function setUsername(string $username): static
{
$this->username = $username;

return $this;
}

// Getter and setter for password

public function getPassword(): ?string
{
return $this->password;
}

public function setPassword(?string $password): static
{
$this->password = $password;

return $this;
}

// Getter and setter for givenName

public function getGivenName(): ?string
{
return $this->givenName;
}

public function setGivenName(string $givenName): static
{
$this->givenName = $givenName;

return $this;
}

// Getter and setter for email

public function getEmail(): ?string
{
return $this->email;
}

public function setEmail(?string $email): static
{
$this->email = $email;

return $this;
}

// Methods required by UserInterface

public function getRoles(): array
{
return ['ROLE_USER'];
}

public function eraseCredentials(): void
{
return;
}

public function getUserIdentifier(): string
{
return $this->getUsername();
}
}
