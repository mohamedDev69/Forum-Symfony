<?php

namespace App\Controller;
use App\Entity\Inscription;
use App\Entity\Atelier;
use App\Form\AtelierType;
use App\Repository\AtelierRepository;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/atelier')]

class AtelierController extends AbstractController
{
    #[Route('/', name: 'app_atelier_index', methods: ['GET'])]
    public function index(AtelierRepository $atelierRepository): Response
    {
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $atelierRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_atelier_new', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ECOLE') or is_granted('ROLE_ADMIN')")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $atelier = new Atelier();
        $form = $this->createForm(AtelierType::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('atelier/new.html.twig', [
            'atelier' => $atelier,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_atelier_show', methods: ['GET'])]
    public function show(Atelier $atelier): Response
    {
        return $this->render('atelier/show.html.twig', [
            'atelier' => $atelier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_atelier_edit', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_ECOLE') or is_granted('ROLE_ADMIN')")]
    public function edit(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AtelierType::class, $atelier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('atelier/edit.html.twig', [
            'atelier' => $atelier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_atelier_delete', methods: ['POST'])]
    #[Security("is_granted('ROLE_ECOLE') or is_granted('ROLE_ADMIN')")]
    public function delete(Request $request, Atelier $atelier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$atelier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($atelier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_atelier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/inscription/{id}', name: 'app_inscription', methods: ['POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function inscription(AtelierRepository $atelierRepository, Atelier $atelier, EntityManagerInterface $entityManager, EleveRepository $eleveRepository): Response
    {
        $user = $this->getUser();
        $eleve = $eleveRepository->findByUserId($user->getId())[0];
        $inscription = new Inscription();
        $inscription->setAtelier($atelier);
        $inscription->setEleve($eleve);
        $inscription->setDateInscription(new \DateTime());

        
        $entityManager->persist($inscription);
        $entityManager->flush();

        
        $this->addFlash('success', 'Inscription réussie !');

        return $this->redirectToRoute('app_atelier_index');
    }
    #[Route('/inscription', name: 'app_atelier_inscription', methods: ['GET'])]
    #[Security("is_granted('ROLE_ADMIN')")]
    public function atelierInscription(AtelierRepository $atelierRepository): Response
    {
        return $this->render('atelier/list_atelier.html.twig', [
            'ateliers' => $atelierRepository->findAll(),
        ]);
    }
}
