<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 40)]
    private ?string $contact_info = null;

    #[ORM\ManyToMany(targetEntity: Forum::class, inversedBy: 'sponsors')]
    private Collection $forum;

    public function __construct()
    {
        $this->forum = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContactInfo(): ?string
    {
        return $this->contact_info;
    }

    public function setContactInfo(string $contact_info): static
    {
        $this->contact_info = $contact_info;

        return $this;
    }

    /**
     * @return Collection<int, Forum>
     */
    public function getForum(): Collection
    {
        return $this->forum;
    }

    public function addForum(Forum $forum): static
    {
        if (!$this->forum->contains($forum)) {
            $this->forum->add($forum);
        }

        return $this;
    }

    public function removeForum(Forum $forum): static
    {
        $this->forum->removeElement($forum);

        return $this;
    }
}
