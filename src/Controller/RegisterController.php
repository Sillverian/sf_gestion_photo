<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, 
    UserPasswordHasherInterface $userPasswordHasherInterface, 
    UserAuthenticatorInterface $userAuthenticatorInterface, 
    UserAuthenticator $userAuthenticator, 
    EntityManagerInterface $entityManagerInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        return $this->render('register/register.html.twig', [
            'registerForm' => $form->createView(),
        ]);
    }
}
