<?php

namespace App\Repository;

use App\Entity\PlayerVehiclesPlayed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlayerVehiclesPlayedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerVehiclesPlayed::class);
    }
}