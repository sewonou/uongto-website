<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]

/**
 * Class Option
 * @package App\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Asset\NotBlank(message: "Le titre est Obligartoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "Le titre doit être supérieur à 2 caractères", maxMessage: "Le titre doit être inférieur à 255 caractères")]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Asset\NotBlank(message: "La meta description  est obligartoire")]
    #[Assert\Length(min: 2,max: 255,minMessage: "la description doit être supérieur à 2 caractères", maxMessage: "La description doit être inférieur à 255 caractères")]
    private ?string $metaDescription = null;



    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
    private Collection $posts;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    private ?User $author = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\ManyToMany(targetEntity: Option::class, inversedBy: 'categories')]
    private Collection $types;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug()
    {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
        $this->updateAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

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

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->addCategory($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeCategory($this);
        }

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

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection<int, Option>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Option $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Option $type): self
    {
        $this->types->removeElement($type);

        return $this;
    }
}
