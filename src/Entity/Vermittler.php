<?php

/**
 * author: Adam Lukasz Piekarski
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VermittlerRepository;

#[ApiResource]
#[Get(uriTemplate: '/foo/vermittler/')]
#[ORM\Entity(repositoryClass: VermittlerRepository::class)]
#[ORM\Table(name: "vermittler", schema: "std")]
class Vermittler
{
    #[ORM\Id]
    #[ORM\Column(name: "id", type: "integer")]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "std.vermittler_id_seq", allocationSize: 1, initialValue: 1)]
    private int $id;

    #[ORM\Column(name: "nummer", type: "string", length: 36, nullable: false)]
    private ?string $nummer;

    #[ORM\Column(name: "vorname", type: "string", length: 255, nullable: true)]
    private ?string $vorname;

    #[ORM\Column(name: "nachname", type: "string", length: 255, nullable: true)]
    private ?string $nachname;

    #[ORM\Column(name: "firma", type: "string", length: 255, nullable: true)]
    private ?string $firma;

    #[ORM\Column(name: "geloescht", type: "boolean", nullable: false)]
    private bool $geloescht;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNummer(): ?string
    {
        return $this->nummer;
    }

    public function setNummer(string $nummer): self
    {
        $this->nummer = $nummer;

        return $this;
    }

    public function getVorname(): ?string
    {
        return $this->vorname;
    }

    public function setVorname(?string $vorname): self
    {
        $this->vorname = $vorname;

        return $this;
    }

    public function getNachname(): ?string
    {
        return $this->nachname;
    }

    public function setNachname(?string $nachname): self
    {
        $this->nachname = $nachname;

        return $this;
    }

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function isGeloescht(): ?bool
    {
        return $this->geloescht;
    }

    public function setGeloescht(bool $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }
}