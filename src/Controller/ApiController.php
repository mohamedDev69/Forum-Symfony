<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
class ApiController extends AbstractController
{
    /**
     * @Route("/api/ateliers/inscriptions", name="api_ateliers_inscriptions", methods={"GET"})
     */
    public function getNombreInscrits(Request $request, InscriptionRepository $inscriptionRepository): JsonResponse
    {
        $atelierId = $request->query->get('atelier');
        $creneauId = $request->query->get('creneau');

        $data = $inscriptionRepository->getNombreInscritsParAtelierEtCreneau($atelierId, $creneauId);
        return $this->json($data);
    }
}