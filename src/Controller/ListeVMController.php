<?php

namespace App\Controller;

use App\Entity\User2;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class ListeVMController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route('/connection', name: 'app_connection')]
    public function connection(AuthenticationUtils $auth): Response
    {
        $error = $auth->getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();

        return $this->render('connection.html.twig', [
            'controller_name' => 'ListeVMController',
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    
    #[Route('/liste/v/m', name: 'app_liste_v_m')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_connection');
        }

        return $this->render('liste_vm/index.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }


    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em
    ): Response {
        $user = new User2();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = (string) $form->get('plainPassword')->getData();
            $user->setPassword($hasher->hashPassword($user, $plainPassword));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_connection');
        }

        return $this->render('register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/forgeten_password', name: 'app_forgeten_password')]
    public function forgeten_password(): Response
    {
        return $this->render('ForgetenPassword.html.twig', [
            'controller_name' => 'ForgetenPasswordController',
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // Intercepté par le firewall. Ne sera jamais exécuté.
    }

}
