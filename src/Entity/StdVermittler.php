<?php

namespace App\Entity;

use App\Repository\StdVermittlerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StdVermittlerRepository::class)]
#[ORM\Table(name: 'std.vermittler')]
class StdVermittler
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\SequenceGenerator(sequenceName: 'std.vermittler_id_seq', allocationSize: 1, initialValue: 1)]
    private $id;

    #[ORM\Column(name: 'nummer', type: 'string', length: 36, nullable: false, options: [
        "default" => 'upper("left"((gen_random_uuid())::text, 8))'
    ])]
    private $nummer = null;

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private $vorname;

    #[ORM\Column(name: 'nachname', type: 'string', length: 255, nullable: true)]
    private $nachname;

    #[ORM\Column(name: 'firma', type: 'string', length: 255, nullable: true)]
    private $firma;

    #[ORM\Column(name: 'geloescht', type: 'boolean', nullable: false)]
    private $geloescht = false;

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
