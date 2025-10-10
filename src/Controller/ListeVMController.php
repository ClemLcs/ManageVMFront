<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListeVMController extends AbstractController
{

        #[Route('/connection', name: 'app_connection')]
    public function connection(): Response
    {
        return $this->render('connection.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }


    #[Route('/liste/v/m', name: 'app_liste_v_m')]
    public function index(): Response
    {
        return $this->render('liste_vm/index.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }

    

        #[Route('/inscription', name: 'app_inscription')]
    public function inscription(): Response
    {
        return $this->render('inscription.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }

        #[Route('/forgeten_password', name: 'app_forgeten_password')]
    public function forgeten_password(): Response
    {
        return $this->render('ForgetenPassword.html.twig', [
            'controller_name' => 'ForgetenPasswordController',
        ]);
    }
}
