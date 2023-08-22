<?php

/**
 * author: Adam Lukasz Piekarski
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use DateTimeInterface as Date;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\KundeRepository;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\VirtualProperty;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get(uriTemplate: '/foo/kunden/', formats: ['json'])]
#[Get(uriTemplate: '/foo/kunden/{id}', formats: ['json'])]
#[Put(uriTemplate: '/foo/kunden/{id}', formats: ['json'])]
#[ApiFilter(BooleanFilter::class, properties: ["geloescht"])]
#[Delete(uriTemplate: '/foo/kunden/{id}', formats: ['json'])]
#[ORM\Entity(repositoryClass: KundeRepository::class)]
#[ORM\Table(name: "tbl_kunden", schema: "std")]
#[ORM\Index(columns: ["vermittler_id"], name: "IDX_680E0AD091EC85B5")]
class Kunde
{
    #[Groups('get')]
    #[ORM\Id]
    #[ORM\Column(name: "id", type: "string", length: 255)]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "std.tbl_kunden_id_seq", allocationSize: 1, initialValue: 1)]
    private ?string $id;

    #[Groups('get')]
    #[ORM\Column(name: "name", type: "string", length: 255, nullable: true)]
    private ?string $name;

    #[Groups('get')]
    #[ORM\Column(name: "vorname", type: "string", length: 255, nullable: true)]
    private ?string $vorname;

    #[Groups('get')]
    #[ORM\Column(name: "firma", type: "text", nullable: true)]
    private ?string $firma;

    #[Groups('get')]
    #[ORM\Column(name: "geburtsdatum", type: "datetime", nullable: true)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    private ?Date $geburtsdatum;

    #[Ignore]
    #[ORM\Column(name: "geloescht", type: "integer", nullable: true)]
    private ?int $geloescht;

    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'enum' => ['männlich', 'weiblich', 'divers'],
        ]
    )]
    #[Groups('get')]
    #[ORM\Column(name: "geschlecht", type: "string", nullable: true)]
    private ?string $geschlecht;

    #[Groups('get')]
    #[ORM\Column(name: "email", type: "text", nullable: true)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email;

    #[Groups('get')]
    #[ORM\OneToMany(mappedBy: "kunden", targetEntity: KundenAdresse::class)]
    #[Assert\Type('array<' . KundenAdresse::class . '>')]
    private Collection $adressen;

    #[Ignore]
    #[ORM\ManyToOne(targetEntity: Vermittler::class)]
    #[ORM\JoinColumn(name: "vermittler_id", referencedColumnName: "id")]
    private ?Vermittler $vermittler;

    #[Groups('get')]
    #[JMS\VirtualProperty]
    public function getVermittlerId(): int
    {
        return $this->vermittler->getId();
    }


    public function __construct()
    {
        $this->adressen = new ArrayCollection();
    }

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

    public function getGeburtsdatum(): ?Date
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(?Date $geburtsdatum): self
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

    /**
     * @return ArrayCollection<Adresse>
     * Changed structure, because of expected JSON structure
     */
    public function getAdressen(): Collection
    {
        $collection = new ArrayCollection();
        foreach ($this->adressen as $adresse) {
            $detailsArray = [];
            $detailsArray["geschaeftlich"] = $adresse->isGeschaeftlich();
            $detailsArray["rechnungsadresse"] = $adresse->isRechnungsadresse();
            $kundenAdresse = $adresse->getAdresse();
            $kundenAdresse->setDetails($detailsArray);
            $collection->add($kundenAdresse);
        }
        return $collection;
    }

    public function addAdressen(KundenAdresse $adressen): self
    {
        if (!$this->adressen->contains($adressen)) {
            $this->adressen->add($adressen);
            $adressen->setKunden($this);
        }

        return $this;
    }

    public function removeAdressen(KundenAdresse $adressen): self
    {
        if ($this->adressen->removeElement($adressen)) {
            // set the owning side to null (unless already changed)
            if ($adressen->getKunden() === $this) {
                $adressen->setKunden(null);
            }
        }

        return $this;
    }

    public function getVermittler(): ?Vermittler
    {
        return $this->vermittler;
    }

    public function setVermittler(?Vermittler $vermittler): self
    {
        $this->vermittler = $vermittler;

        return $this;
    }
}