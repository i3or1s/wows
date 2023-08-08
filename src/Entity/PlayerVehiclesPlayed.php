<?php

namespace App\Entity;

use App\Repository\PlayerVehiclesPlayedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerVehiclesPlayedRepository::class)]
class PlayerVehiclesPlayed implements \JsonSerializable
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: 'vehiclePlayed')]
    #[ORM\JoinColumn(name: 'player_id', referencedColumnName: 'id')]
    public Player $player;

    #[ORM\ManyToOne(targetEntity: WikiVehicle::class, inversedBy: 'vehiclePlayed')]
    #[ORM\JoinColumn(name: 'wiki_vehicle_id', referencedColumnName: 'id')]
    public WikiVehicle $vehicle;

    #[ORM\Column(type: 'string', length: 64)]
    public string $battles = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $damage = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $xp = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $wins = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $frags = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $personalRating = '';

    #[ORM\Column(type: 'string', length: 64)]
    public string $wn8 = '';

    #[ORM\Column(type: 'datetime')]
    public \DateTime $createdAt;

    public function __construct(?int $id, Player $player, WikiVehicle $vehicle, string $battles, string $damage, string $xp, string $wins, string $frags, string $personalRating, string $wn8)
    {
        $this->id = $id;
        $this->player = $player;
        $this->vehicle = $vehicle;
        $this->battles = $battles;
        $this->damage = $damage;
        $this->xp = $xp;
        $this->wins = $wins;
        $this->frags = $frags;
        $this->personalRating = $personalRating;
        $this->wn8 = $wn8;
        $this->createdAt = new \DateTime();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'player' => $this->player->wid,
            'vehicle' => $this->vehicle,
            'battles' => $this->battles,
            'damage' => $this->damage,
            'xp' => $this->xp,
            'wins' => $this->wins,
            'frags' => $this->frags,
            'personalRating' => $this->personalRating,
            'wn8' => $this->wn8,
            'createdAt' => $this->createdAt->format('Y-m-d')
        ];
    }


}