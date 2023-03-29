<?php

namespace App\Entity;

use App\Repository\HistoricRepository;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HistoricRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Historic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Asset\NotBlank(message: "La période de l'historique est Obligartoire")]
    private ?string $year = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Asset\NotBlank(message: "La description est Obligartoire")]
    #[Assert\Length(min: 2, minMessage: "La description doit être supérieur à 2 caractères")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\ManyToOne(inversedBy: 'historics')]
    private ?User $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug()
    {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->year);
        }
        $this->updateAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }
}
