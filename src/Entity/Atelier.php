<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AtelierRepository::class)]
class Atelier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 100)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_atelier = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    private ?Forum $forum = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    private ?Secteur $sector = null;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    private ?Salle $room = null;

    #[ORM\OneToMany(mappedBy: 'atelier', targetEntity: Inscription::class)]
    private Collection $inscriptions;

    #[ORM\ManyToOne(inversedBy: 'ateliers')]
    private ?Intervenant $intervenant = null;

    #[ORM\Column(length: 20)]
    private ?string $heure = null;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateAtelier(): ?\DateTimeInterface
    {
        return $this->date_atelier;
    }

    public function setDateAtelier(\DateTimeInterface $date_atelier): static
    {
        $this->date_atelier = $date_atelier;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): static
    {
        $this->forum = $forum;

        return $this;
    }

    public function getSector(): ?Secteur
    {
        return $this->sector;
    }

    public function setSector(?Secteur $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    public function getRoom(): ?Salle
    {
        return $this->room;
    }

    public function setRoom(?Salle $room): static
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setAtelier($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getAtelier() === $this) {
                $inscription->setAtelier(null);
            }
        }

        return $this;
    }

    public function getIntervenant(): ?Intervenant
    {
        return $this->intervenant;
    }

    public function setIntervenant(?Intervenant $intervenant): static
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): static
    {
        $this->heure = $heure;

        return $this;
    }
}
