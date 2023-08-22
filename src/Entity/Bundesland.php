<?php

/**
 * author: Adam Lukasz Piekarski
 */

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BundeslandRepository;

#[ApiResource]
#[Get(uriTemplate: '/foo/bundesland')]
#[ORM\Entity(repositoryClass: BundeslandRepository::class)]
class Bundesland
{
    #[ORM\Id]
    #[ORM\Column(name: "kuerzel", type: "string", length: 2)]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\SequenceGenerator(sequenceName: "bundesland_kuerzel_seq", allocationSize: 1, initialValue: 1)]
    private ?string $kuerzel;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $name;

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