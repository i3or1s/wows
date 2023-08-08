<?php

namespace App\Controller;

use App\Repository\WikiVehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wiki-vehicles', name: 'wiki_vehicle')]
class WikiVehicle extends AbstractController
{
    public function __invoke(WikiVehicleRepository $wikiVehicle): JsonResponse
    {
        $allVehicles = $wikiVehicle->findAll();
        return new JsonResponse($allVehicles);
    }
}