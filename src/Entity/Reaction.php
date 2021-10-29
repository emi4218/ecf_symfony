<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 */
class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Commentaire::class, inversedBy="reactions")
     */
    private $emote;

    public function __construct()
    {
        $this->emote = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getEmote(): Collection
    {
        return $this->emote;
    }

    public function addEmote(Commentaire $emote): self
    {
        if (!$this->emote->contains($emote)) {
            $this->emote[] = $emote;
        }

        return $this;
    }

    public function removeEmote(Commentaire $emote): self
    {
        $this->emote->removeElement($emote);

        return $this;
    }
}
