<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListeVMController extends AbstractController
{
    #[Route('/liste/v/m', name: 'app_liste_v_m')]
    public function index(): Response
    {
        return $this->render('liste_vm/index.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }
}
