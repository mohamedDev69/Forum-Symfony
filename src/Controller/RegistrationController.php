<?php

namespace App\Controller;

use App\Entity\Ecole;
use App\Entity\Eleve;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\AtelierRepository;
use App\Repository\EleveRepository;
use App\Repository\InscriptionRepository;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager,  MailerInterface $mailer): Response
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
            $mailContent = "<p>Vous venez de vous inscrire en tant qu'étudiant</p><p>Vous pouvez desormais vous inscire à l'atelier de votre choix</p>";
        
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
                $mailContent = "<p>Vous venez de vous inscrire en tant qu'école</p><p>Vous pouvez desormais creer et gérer vos ateliers</p>";
                $etablissement = new Ecole();
                $etablissement->setName($name);
                $etablissement->setAdress($adress);
                $etablissement->setUser($user);
                $etablissement->setMail($mail);
                $entityManager->persist($etablissement);
                $entityManager->flush();
            }

        
            $email = (new Email())
            ->from($mail)
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre site')
            ->text('Contenu de l\'e-mail')
            ->html($mailContent);

            try {
                $mailer->send($email);
            } catch (\Exception $e) {
                throw new \Exception($e);
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

    #[Route('/showProfilUser', name: 'app_profil_show', methods: ['GET'])]
    public function showProfil(InscriptionRepository $inscriptionRepository, EleveRepository $eleveRepository): Response
    {
        $user = $this->getUser();

        $eleve = $eleveRepository->findByUserId($user->getId());

        if ($eleve){
            $inscription = $inscriptionRepository->findByEleveId($eleve[0]->getId());
            $eleve = $eleve[0];
        }
        else {
            $inscription = [];
        }

        return $this->render('profil/index.html.twig', [
            'identifiant' => $eleve->getId(),
            'eleve' => $eleve,
            'email' => $user->getUserIdentifier(),
            'inscriptions' => $inscription
        ]);
    }

}
