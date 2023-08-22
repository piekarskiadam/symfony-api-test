<?php

/**
 * author: Adam Lukasz Piekarski
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdressseRepository;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(normalizationContext: ['groups' => ['get']])]
#[Get(uriTemplate: '/foo/adresse/')]
#[ORM\Entity(repositoryClass: AdressseRepository::class)]
#[ORM\Table(name: "adresse", schema: "std")]
#[ORM\Index(columns: ["bundesland"], name: "IDX_40A5D758593BEEEC")]
class Adresse
{
    #[Groups('get')]
    #[SerializedName("adresseId")]
    #[ORM\Id]
    #[ORM\Column(name: "adresse_id", type: "integer")]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "std.adresse_adresse_id_seq", allocationSize: 1, initialValue: 1)]
    private ?int $adresse_id;

    #[Groups('get')]
    #[ORM\Column(name: "strasse", type: "text", nullable: true)]
    private ?string $strasse;

    #[Groups('get')]
    #[ORM\Column(name: "plz", type: "string", length: 10, nullable: true)]
    private ?string $plz;

    #[Groups('get')]
    #[ORM\Column(name: "ort", type: "text", nullable: true)]
    private ?string $ort;

    #[Ignore]
    #[ORM\OneToMany(mappedBy: "adresse", targetEntity: KundenAdresse::class)]
    private Collection $kundenAdressen;

    #[Ignore] // todo: Because of permission denied in database
    //    #[Groups('get')]
    #[ORM\ManyToOne(targetEntity: Bundesland::class)]
    #[ORM\JoinColumn(name: "bundesland", referencedColumnName: "kuerzel")]
    private Bundesland|null $bundesland;

    // Virtual property for expected JSON structure
    private array $details;

    public function __construct()
    {
        $this->kundenAdressen = new ArrayCollection();
    }

    #[Groups('get')]
    #[JMS\VirtualProperty]
    public function getDetails(): array
    {
       return $this->details;
    }

    public function setDetails(array $array): void{
        $this->details = $array;
    }

    public function getAdresseId(): ?int
    {
        return $this->adresse_id;
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

    /**
     * @return Collection<int, KundenAdresse>
     */
    public function getKundenAdressen(): Collection
    {
        return $this->kundenAdressen;
    }

    public function addKundenAdressen(KundenAdresse $kundenAdressen): self
    {
        if (!$this->kundenAdressen->contains($kundenAdressen)) {
            $this->kundenAdressen->add($kundenAdressen);
            $kundenAdressen->setAdresse($this);
        }

        return $this;
    }

    public function removeKundenAdressen(KundenAdresse $kundenAdressen): self
    {
        if ($this->kundenAdressen->removeElement($kundenAdressen)) {
            // set the owning side to null (unless already changed)
            if ($kundenAdressen->getAdresse() === $this) {
                $kundenAdressen->setAdresse(null);
            }
        }

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