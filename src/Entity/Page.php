<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\HasLifecycleCallbacks]

/**
 * Class Page
 * @package App\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: "Le titre est obligatoire")]
    private ?string $codeName = null;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Post::class)]
    private Collection $posts;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Personality::class)]
    private Collection $personalities;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Testimonial::class)]
    private Collection $testimonials;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->personalities = new ArrayCollection();
        $this->testimonials = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug()
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->title);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(?string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

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
            $post->setPage($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getPage() === $this) {
                $post->setPage(null);
            }
        }

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
     * @return Collection<int, Personality>
     */
    public function getPersonalities(): Collection
    {
        return $this->personalities;
    }

    public function addPersonality(Personality $personality): self
    {
        if (!$this->personalities->contains($personality)) {
            $this->personalities->add($personality);
            $personality->setPage($this);
        }

        return $this;
    }

    public function removePersonality(Personality $personality): self
    {
        if ($this->personalities->removeElement($personality)) {
            // set the owning side to null (unless already changed)
            if ($personality->getPage() === $this) {
                $personality->setPage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Testimonial>
     */
    public function getTestimonials(): Collection
    {
        return $this->testimonials;
    }

    public function addTestimonial(Testimonial $testimonial): self
    {
        if (!$this->testimonials->contains($testimonial)) {
            $this->testimonials->add($testimonial);
            $testimonial->setPage($this);
        }

        return $this;
    }

    public function removeTestimonial(Testimonial $testimonial): self
    {
        if ($this->testimonials->removeElement($testimonial)) {
            // set the owning side to null (unless already changed)
            if ($testimonial->getPage() === $this) {
                $testimonial->setPage(null);
            }
        }

        return $this;
    }
}
