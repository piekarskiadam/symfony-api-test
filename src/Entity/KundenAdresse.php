<?php

/**
 * author: Adam Lukasz Piekarski
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\KundenAdresseRepository;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get(uriTemplate: '/foo/kunden/adresse/')]
#[ORM\Entity(repositoryClass: KundenAdresseRepository::class)]
#[ORM\Table(name: "kunde_adresse", schema: "std")]
class KundenAdresse
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private ?int $id;

    #[Groups('get')]
    #[ORM\Column(type: "boolean", length: 1, nullable: true, options: ["default"=>0])]
    private bool $geschaeftlich;

    #[Groups('get')]
    #[ORM\Column(type: "boolean", length: 1, nullable: true, options: ["default"=>0])]
    private bool $rechnungsadresse;

    #[ORM\Column(type: "boolean", length: 1, nullable: true, options: ["default"=>0])]
    private bool $geloescht;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Kunde::class, inversedBy: "adressen")]
    #[ORM\JoinColumn(name: "kunde_id", referencedColumnName: "id")]
    private ?\App\Entity\Kunde $kunden;

    #[Groups('get')]
    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: "kundenAdressen")]
    #[ORM\JoinColumn(name: "adresse_id", referencedColumnName: "adresse_id")]
    private ?Adresse $adresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isGeschaeftlich(): ?bool
    {
        return $this->geschaeftlich;
    }

    public function setGeschaeftlich(?bool $geschaeftlich): self
    {
        $this->geschaeftlich = $geschaeftlich;

        return $this;
    }

    public function isRechnungsadresse(): ?bool
    {
        return $this->rechnungsadresse;
    }

    public function setRechnungsadresse(?bool $rechnungsadresse): self
    {
        $this->rechnungsadresse = $rechnungsadresse;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(?bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getKunden(): ?Kunde
    {
        return $this->kunden;
    }

    public function setKunden(?Kunde $kunden): self
    {
        $this->kunden = $kunden;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}