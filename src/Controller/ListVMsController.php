<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListVMsController extends AbstractController
{
    #[Route('/list/v/ms', name: 'app_list_v_ms')]
    public function index(): Response
    {
        // Example VM data - in a real app you'd fetch this from the database or an API
        $vms = [
            [
                'id' => 1, 
                'name' => 'web-01', 
                'status' => 'running', 
                'ip' => '10.0.0.11', 
                'cpu' => 2, 
                'ram' => '4GB',
                'snapshots' => [
                    ['name' => 'snapshot-2025-10-15-01', 'date' => '15/10/2025 10:30', 'size' => '2.5 GB', 'description' => 'Avant mise à jour système'],
                    ['name' => 'snapshot-2025-10-14-01', 'date' => '14/10/2025 15:20', 'size' => '2.3 GB', 'description' => 'Configuration initiale'],
                ],
                'events' => [
                    ['date' => '15/10/2025 14:23', 'type' => 'info', 'message' => 'VM démarrée', 'user' => 'admin'],
                    ['date' => '15/10/2025 10:15', 'type' => 'maintenance', 'message' => 'Snapshot créé', 'user' => 'admin'],
                    ['date' => '14/10/2025 18:45', 'type' => 'info', 'message' => 'VM arrêtée', 'user' => 'admin'],
                ]
            ],
            [
                'id' => 2, 
                'name' => 'db-01', 
                'status' => 'stopped', 
                'ip' => '10.0.0.12', 
                'cpu' => 4, 
                'ram' => '8GB',
                'snapshots' => [
                    ['name' => 'snapshot-2025-10-13-01', 'date' => '13/10/2025 09:00', 'size' => '5.2 GB', 'description' => 'Backup avant migration'],
                ],
                'events' => [
                    ['date' => '15/10/2025 09:00', 'type' => 'info', 'message' => 'VM arrêtée', 'user' => 'admin'],
                    ['date' => '13/10/2025 09:15', 'type' => 'maintenance', 'message' => 'Snapshot créé', 'user' => 'admin'],
                ]
            ],
            [
                'id' => 3, 
                'name' => 'cache-01', 
                'status' => 'running', 
                'ip' => '10.0.0.13', 
                'cpu' => 1, 
                'ram' => '2GB',
                'snapshots' => [
                    ['name' => 'snapshot-2025-10-12-01', 'date' => '12/10/2025 14:00', 'size' => '1.8 GB', 'description' => 'Configuration Redis'],
                ],
                'events' => [
                    ['date' => '15/10/2025 08:30', 'type' => 'info', 'message' => 'VM démarrée', 'user' => 'admin'],
                    ['date' => '12/10/2025 14:30', 'type' => 'maintenance', 'message' => 'Snapshot créé', 'user' => 'admin'],
                ]
            ],
        ];

        return $this->render('list_v_ms/index.html.twig', [
            'controller_name' => 'ListVMsController',
            'vms' => $vms,
        ]);
    }

    #[Route('/vm/create', name: 'app_vm_create')]
    public function create(): Response
    {
        return $this->render('vm/create.html.twig');
    }

    #[Route('/vm/{vmid}', name: 'app_vm_details', requirements: ['vmid' => '\d+'])]
    public function details(int $vmid): Response
    {
        // Données VM en dur pour la démonstration
        $vmData = [
            'vmid' => $vmid,
            'name' => 'web-01',
            'status' => 'running',
            'node' => 'proxmox-01',
            'cpus' => 2,
            'maxmem' => 4294967296, // 4GB en bytes
            'mem' => 2147483648, // 2GB utilisés
            'maxdisk' => 53687091200, // 50GB en bytes
            'disk' => 10737418240, // 10GB utilisés
            'uptime' => 86400, // 1 jour en secondes
            'cpu' => 0.25, // 25% CPU
            'netin' => 104857600, // 100MB
            'netout' => 52428800, // 50MB
        ];

        // Données des snapshots en dur
        $snapshots = [
            [
                'name' => 'snapshot-2025-10-15-01',
                'snaptime' => 1728990600, // timestamp
                'description' => 'Avant mise à jour système',
                'size' => 2684354560 // 2.5GB
            ],
            [
                'name' => 'snapshot-2025-10-14-01', 
                'snaptime' => 1728903600,
                'description' => 'Configuration initiale',
                'size' => 2469606195 // 2.3GB
            ]
        ];

        // Données des événements en dur
        $events = [
            [
                'date' => '15/10/2025 14:23',
                'type' => 'info',
                'message' => 'VM démarrée',
                'user' => 'admin'
            ],
            [
                'date' => '15/10/2025 10:15',
                'type' => 'maintenance', 
                'message' => 'Snapshot créé',
                'user' => 'admin'
            ],
            [
                'date' => '14/10/2025 18:45',
                'type' => 'info',
                'message' => 'VM arrêtée',
                'user' => 'admin'
            ]
        ];

        return $this->render('vm/details.html.twig', [
            'vm' => $vmData,
            'snapshots' => $snapshots,
            'events' => $events,
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        // Redirect root URL to the VM listing page
        return $this->redirectToRoute('app_list_v_ms');
    }
}
