<?php

// src/Controller/AdminController.php

namespace App\Controller;

use App\Entity\AppUser;
use App\Form\UserType;
use App\Repository\AppUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
private $entityManager;

public function __construct(EntityManagerInterface $entityManager)
{
$this->entityManager = $entityManager;
}

#[Route('/dashboard', name: 'admin_dashboard')]
public function dashboard(AppUserRepository $userRepository): Response
{
// Fetch all users from the database
$users = $userRepository->findAll();

return $this->render('admin/dashboard.html.twig', [
'users' => $users,
]);
}

#[Route('/create_user', name: 'admin_create_user')]
public function createUser(Request $request): Response
{
// Check if user is authenticated and has admin role
$user = $this->getUser();
if (!$user || $user->getId() !== 1) {
throw $this->createAccessDeniedException('Only user with ID 1 can create users.');
}

$newUser = new AppUser();
$form = $this->createForm(UserType::class, $newUser);
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
// Encode the password before saving to the database
$encodedPassword = password_hash($form->get('password')->getData(), PASSWORD_DEFAULT);
$newUser->setPassword($encodedPassword);

// Save the new user to the database
$this->entityManager->persist($newUser);
$this->entityManager->flush();

$this->addFlash('success', 'User created successfully.');

return $this->redirectToRoute('admin_dashboard');
}

return $this->render('admin/create_user.html.twig', [
'form' => $form->createView(),
]);
}
}
