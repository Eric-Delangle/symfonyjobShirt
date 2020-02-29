<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Products", inversedBy="categories")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $article;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registredAt;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Products[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Products $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Products $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
        }

        return $this;
    }

    public function getRegistredAt(): ?\DateTimeInterface
    {
        return $this->registredAt;
    }

    public function setRegistredAt(\DateTimeInterface $registredAt): self
    {
        $this->registredAt = $registredAt;

        return $this;
    }

    public function __toString() {
        return (string) $this->getId();
    }
    
}
