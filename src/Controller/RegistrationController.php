<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
        
            $entityManager->persist($user);
            $entityManager->flush();
        
            $formData = $request->request->all()['registration_form'];
            $adress = $formData['adress'];
            $userType = $formData['userType'];
            $name = $formData['name'];
            $mail = $formData['email'];
        
            if ($userType == "etudiant") {
                $uniqueInfo = $formData['unique_info'];
                $schoolInfo = $formData['school_info'];
                $ecole = $formData['ecole'];
                $etudiant = new Eleve();
                $etudiant->setName($name);
                $etudiant->setUser($user);
                $etudiant->setSchoolInfo($schoolInfo);
                $etudiant->setUniqueInfo($uniqueInfo);
                $school = $entityManager->getRepository(Ecole::class)->find($ecole);
                $etudiant->setEcole($school);
                $entityManager->persist($etudiant);
                $entityManager->flush();
            } else if($userType == "ecole"){
                $etablissement = new Ecole();
                $etablissement->setName($name);
                $etablissement->setAdress($adress);
                $etablissement->setUser($user);
                $etablissement->setMail($mail);
                $entityManager->persist($etablissement);
                $entityManager->flush();
            }
        
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
    }
}