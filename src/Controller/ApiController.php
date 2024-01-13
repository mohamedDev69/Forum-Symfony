<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
class ApiController
{
    /**
     * @Route("/api/ateliers/inscriptions", name="api_ateliers_inscriptions", methods={"GET"})
     */
    public function getNombreInscrits(Request $request, InscriptionRepository $repo): JsonResponse
    {
        $atelierId = $request->query->get('atelier');
        $creneauId = $request->query->get('creneau');

        $data = $repo->getNombreInscritsParAtelierEtCreneau($atelierId, $creneauId);
        return $this->json($data);
    }
}