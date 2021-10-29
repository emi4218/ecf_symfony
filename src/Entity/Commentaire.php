<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="date")
     */
    private $dateCommentaire;

    /**
     * @ORM\Column(type="text")
     */
    private $texteCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $auteur;

    /**
     * @ORM\ManyToMany(targetEntity=Reaction::class, mappedBy="emote")
     */
    private $reactions;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comArticle;

    public function __construct()
    {
        $this->reactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire): self
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    public function getTexteCommentaire(): ?string
    {
        return $this->texteCommentaire;
    }

    public function setTexteCommentaire(string $texteCommentaire): self
    {
        $this->texteCommentaire = $texteCommentaire;

        return $this;
    }

    public function getAuteur(): ?User
    {
        return $this->auteur;
    }

    public function setAuteur(?User $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection|Reaction[]
     */
    public function getReactions(): Collection
    {
        return $this->reactions;
    }

    public function addReaction(Reaction $reaction): self
    {
        if (!$this->reactions->contains($reaction)) {
            $this->reactions[] = $reaction;
            $reaction->addEmote($this);
        }

        return $this;
    }

    public function removeReaction(Reaction $reaction): self
    {
        if ($this->reactions->removeElement($reaction)) {
            $reaction->removeEmote($this);
        }

        return $this;
    }

    public function getComArticle(): ?Article
    {
        return $this->comArticle;
    }

    public function setComArticle(?Article $comArticle): self
    {
        $this->comArticle = $comArticle;

        return $this;
    }
}
