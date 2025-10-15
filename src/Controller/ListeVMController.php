<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
        return $this->render('liste_vm/index.html.twig', [
            'controller_name' => 'ListeVMController',
        ]);
    }

    

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);
        $form->handleRequest($request);

        // ⇩⇩ DEBUG : si soumis mais invalide, on pousse les erreurs en flash
        if ($form->isSubmitted() && !$form->isValid()) {

            echo "<script>console.log('in If not valid' );</script>";

            foreach ($form->getErrors(true, true) as $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        echo "<script>console.log('before If' );</script>";

        if ($form->isSubmitted() && $form->isValid()) {

            echo "<script>console.log('in If valid' );</script>";
            // Récupère la valeur du champ RepeatedType "plainPassword"
            // (dans un FormType standard, plainPassword est 'mapped' => false)
            $plain = (string) $form->get('plainPassword')->getData();

            // IMPORTANT : assigne le password (sinon NULL -> violation NOT NULL)
            
            
            $user->setPassword($plain);

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_connection');
            echo "<script>console.log('after redirect' );</script>";
        }

        echo "<script>console.log('after If valid' );</script>";

        return $this->render('inscription.html.twig', [
            'form' => $form->createView(),
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
