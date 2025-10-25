<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GitHubController extends AbstractController
{
    
    #[Route('/connect/github', name: 'connect_github_start')]
    public function connect(ClientRegistry $clientRegistry): Response
    {
        return $clientRegistry->getClient('github')->redirect(['user:email']);
    }

    #[Route('/connect/github/check', name: 'connect_github_check')]
    public function connectCheck(): Response
    {
        return $this->redirectToRoute('app_liste_v_m');
    }

}
