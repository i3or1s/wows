<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/player/{wid}', name: 'player.id')]
class PlayersApi extends AbstractController
{
    public function __invoke(string $wid, PlayerRepository $playerRepository): JsonResponse
    {
        /** @var Player $player */
        $player = $playerRepository->findOneBy(['wid' => $wid]);
        return new JsonResponse($player ?? []);
    }
}