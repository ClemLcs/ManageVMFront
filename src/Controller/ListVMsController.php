<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListVMsController extends AbstractController
{
    #[Route('/list/vms', name: 'app_list_vms')]
    public function index(): Response
    {
        // Example VM data - in a real app you'd fetch this from the database or an API
        $vms = [
            ['id' => 1, 'name' => 'web-01', 'status' => 'running', 'ip' => '10.0.0.11', 'cpu' => 2, 'ram' => '4GB'],
            ['id' => 2, 'name' => 'db-01', 'status' => 'stopped', 'ip' => '10.0.0.12', 'cpu' => 4, 'ram' => '8GB'],
            ['id' => 3, 'name' => 'cache-01', 'status' => 'running', 'ip' => '10.0.0.13', 'cpu' => 1, 'ram' => '2GB'],
        ];

        return $this->render('list_v_ms/index.html.twig', [
            'controller_name' => 'ListVMsController',
            'vms' => $vms,
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        // Redirect root URL to the VM listing page
        return $this->redirectToRoute('app_list_v_ms');
    }
}
