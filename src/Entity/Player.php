<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player implements \JsonSerializable
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    #[Assert\NotNull]
    public string $wid;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank]
    public string $nickname = '';

    #[ORM\Column(type: 'string', length: 4)]
    public string $server = '';

    #[ORM\OneToMany(targetEntity: PlayerVehiclesPlayed::class, mappedBy: 'player', cascade: ['persist', 'remove'])]
    public Collection $vehiclePlayed;

    public function __construct(?int $id, string $wid, string $nickname, string $server)
    {
        $this->id = $id;
        $this->wid = $wid;
        $this->nickname = $nickname;
        $this->server = $server;
        $this->vehiclePlayed = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'wid' => $this->wid,
            'nickname' => $this->nickname,
            'server' => $this->server,
            'played' => $this->vehiclePlayed->toArray(),
        ];
    }


}
