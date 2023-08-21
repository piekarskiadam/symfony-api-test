<?php

namespace App\Entity;

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StdAddressseRepository;
use App\Entity\Bundesland;

#[ORM\Entity(repositoryClass: StdAddressseRepository::class)]
#[ORM\Table(name: 'std.adresse')]
#[ORM\Index(columns: ['bundesland'], name: 'IDX_40A5D758593BEEEC')]
class StdAddresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(name: 'addrese_id', type: 'integer', nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'std.adresse_adresse_id_seq', allocationSize: 1, initialValue: 1 )]
    private $adresseId;

    #[ORM\Column(name: 'strasse', type: 'text', nullable: true)]
    private $strasse;

    #[ORM\Column(name: 'plz', type: 'string', length: 10, nullable: true)]
    private $plz;

    #[ORM\Column(name: 'ort', type: 'text', nullable: true)]
    private $ort;

    #[ORM\ManyToOne(targetEntity: Bundesland::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'bundesland', referencedColumnName: 'kuerzel')]
    private $bundesland;

    public function getAdresseId(): ?int
    {
        return $this->adresseId;
    }

    public function getStrasse(): ?string
    {
        return $this->strasse;
    }

    public function setStrasse(?string $strasse): self
    {
        $this->strasse = $strasse;

        return $this;
    }

    public function getPlz(): ?string
    {
        return $this->plz;
    }

    public function setPlz(?string $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(?string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?Bundesland
    {
        return $this->bundesland;
    }

    public function setBundesland(?Bundesland $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }
}
