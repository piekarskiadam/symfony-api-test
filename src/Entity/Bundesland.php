<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BundeslandRepository;

#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
class Bundesland
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(name: 'kuerzel', type: 'string', length: 2, nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'bundesland_kuerzel_seq', allocationSize: 1, initialValue: 1 )]
    private $kuerzel;

    #[ORM\Column(length:255)]
    private $name;

    public function getKuerzel(): ?string
    {
        return $this->kuerzel;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
