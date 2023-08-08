<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WikiVehicleRepository::class)]
class WikiVehicle implements \JsonSerializable
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string', nullable: false, unique: true)]
    #[Assert\NotNull]
    public string $wid;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank]
    public string $name = '';

    #[ORM\Column]
    #[Assert\NotBlank]
    public int $tier;

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank]
    public string $type = '';

    #[ORM\Column(type: 'string', length: 64)]
    #[Assert\NotBlank]
    public string $nation = '';

    #[ORM\OneToMany(targetEntity: PlayerVehiclesPlayed::class, mappedBy: 'vehicle', cascade: ['persist', 'remove'])]
    public Collection $vehiclePlayed;

    public function __construct(?int $id, string $wid, string $name, int $tier, string $type, string $nation)
    {
        $this->id = $id;
        $this->wid = $wid;
        $this->name = $name;
        $this->tier = $tier;
        $this->type = $type;
        $this->nation = $nation;
        $this->vehiclePlayed = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'wid' => $this->wid,
            'name' => $this->name,
            'tier' => $this->tier,
            'type' => $this->type,
            'nation' => $this->nation,
        ];
    }
}
