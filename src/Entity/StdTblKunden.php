<?php

namespace App\Entity;

use App\Repository\StdTblKundenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StdTblKundenRepository::class)]
#[ORM\Table(name: 'std.tbl_kunden')]
#[ORM\Index(columns: ['vermittler_id'], name: 'IDX_680E0AD091EC85B5')]

class StdTblKunden
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(name: 'id', type: 'string', length: 336, nullable: false, options: [
        "default" => 'upper("left"((gen_random_uuid())::text, 8))'
    ])]
    #[ORM\SequenceGenerator(sequenceName: 'std.tbl_kunden_id_seq', allocationSize: 1, initialValue: 1)]
    private $id = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255, nullable: true)]
    private $name;

    #[ORM\Column(name: 'vorname', type: 'string', length: 255, nullable: true)]
    private $vorname;

    #[ORM\Column(name: 'firma', type: 'text', nullable: true)]
    private $firma;

    #[ORM\Column(name: 'geburtsdatum', type: 'datetime', nullable: true)]
    private $geburtsdatum;

    #[ORM\Column(name: 'geloescht', type: 'integer', nullable: true)]
    private $geloescht;

    #[ORM\Column(name: 'geschlecht', type: 'string', nullable: true)]
    private $geschlecht;

    #[ORM\Column(name: 'email', type: 'text', nullable: true)]
    private $email;

    #[ORM\ManyToOne(targetEntity: StdVermittler::class)]
    #[ORM\JoinColumn(name: 'vermittler_id', referencedColumnName: 'id')]
    private $vermittler;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getFirma(): ?string
    {
        return $this->firma;
    }

    public function setFirma(?string $firma): self
    {
        $this->firma = $firma;

        return $this;
    }

    public function getGeburtsdatum(): ?\DateTimeInterface
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?\DateTimeInterface $geburtsdatum): self
    {
        $this->geburtsdatum = $geburtsdatum;

        return $this;
    }

    public function getGeloescht(): ?int
    {
        return $this->geloescht;
    }

    public function setGeloescht(?int $geloescht): self
    {
        $this->geloescht = $geloescht;

        return $this;
    }

    public function getGeschlecht(): ?string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(?string $geschlecht): self
    {
        $this->geschlecht = $geschlecht;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVermittler(): ?StdVermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?StdVermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }

}
