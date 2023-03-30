<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
/**
 * Class Option
 * @package App\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'posts')]
    #[Assert\NotNull(message: "Vous devez selectionner au moins une catégorie")]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[Assert\NotNull(message: "Vous devez selectionner la page de destination")]
    private ?Page $page = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotNull(message: "Le contenu est obligatoire")]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotNull(message: "La méta description est obligatoire")]
    private ?string $metaDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'media_post', fileNameProperty: 'image')]
    #[Assert\NotNull(message: "L'image d'accroche est obligatoire")]
    private ?File $imageFile = null;


    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $author = null;

    #[ORM\OneToMany(mappedBy: 'post', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(nullable: true)]
    private ?int $count = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updateAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $contentDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondImage = null;

    #[Vich\UploadableField(mapping: 'media_post_alt', fileNameProperty: 'secondImage')]
    private ?File $secondImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thirdImage = null;

    #[Vich\UploadableField(mapping: 'media_post_alt', fileNameProperty: 'thirdImage')]
    private ?File $thirdImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fourthImage = null;

    #[Vich\UploadableField(mapping: 'media_post_alt', fileNameProperty: 'fourthImage')]
    private ?File $fourthImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firthImage = null;

    #[Vich\UploadableField(mapping: 'media_post_alt', fileNameProperty: 'firthImage')]
    private ?File $firthImageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstDocument = null;

    #[Vich\UploadableField(mapping: 'media_file', fileNameProperty: 'firstDocument')]
    private ?File $firstDocumentFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondDocument = null;

    #[Vich\UploadableField(mapping: 'media_file_alt', fileNameProperty: 'secondDocument')]
    private ?File $secondDocumentFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isOnFirst = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function initializeSlug()
    {
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTimeImmutable();
        }
        $this->updateAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {

        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

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

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeImmutable $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }


    public function getContentDescription(): ?string
    {
        return $this->contentDescription;
    }

    public function setContentDescription(?string $contentDescription): self
    {
        $this->contentDescription = $contentDescription;

        return $this;
    }

    public function getSecondImage(): ?string
    {
        return $this->secondImage;
    }

    public function setSecondImage(?string $secondImage): self
    {
        $this->secondImage = $secondImage;

        return $this;
    }

    public function getSecondImageFile(): ?File
    {
        return $this->secondImageFile;
    }

    public function setSecondImageFile(?File $secondImageFile = null): void
    {
        $this->secondImageFile = $secondImageFile;

        if (null !== $secondImageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }


    public function getThirdImage(): ?string
    {
        return $this->thirdImage;
    }

    public function setThirdImage(?string $thirdImage): self
    {
        $this->thirdImage = $thirdImage;

        return $this;
    }

    public function getThirdImageFile(): ?File
    {
        return $this->thirdImageFile;
    }

    public function setThirdImageFile(?File $thirdImageFile = null): void
    {
        $this->thirdImageFile = $thirdImageFile;

        if (null !== $thirdImageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getFourthImage(): ?string
    {
        return $this->fourthImage;
    }

    public function setFourthImage(?string $fourthImage): self
    {
        $this->fourthImage = $fourthImage;

        return $this;
    }

    public function getFourthImageFile(): ?File
    {
        return $this->fourthImageFile;
    }

    public function setFourthImageFile(?File $fourthImageFile = null): void
    {
        $this->fourthImageFile = $fourthImageFile;

        if (null !== $fourthImageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }


    public function getFirthImage(): ?string
    {
        return $this->firthImage;
    }

    public function setFirthImage(?string $firthImage): self
    {
        $this->firthImage = $firthImage;

        return $this;
    }

    public function getFirthImageFile(): ?File
    {
        return $this->firthImageFile;
    }

    public function setFirthImageFile(?File $firthImageFile = null): void
    {
        $this->firthImageFile = $firthImageFile;

        if (null !== $firthImageFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getFirstDocument(): ?string
    {
        return $this->firstDocument;
    }

    public function setFirstDocument(?string $firstDocument): self
    {
        $this->firstDocument = $firstDocument;

        return $this;
    }

    public function getFirstDocumentFile(): ?File
    {
        return $this->firstDocumentFile;
    }

    public function setFirstDocumentFile(?File $firstDocumentFile = null): void
    {
        $this->firstDocumentFile = $firstDocumentFile;

        if (null !== $firstDocumentFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getSecondDocument(): ?string
    {
        return $this->secondDocument;
    }

    public function setSecondDocument(?string $secondDocument): self
    {
        $this->secondDocument = $secondDocument;

        return $this;
    }

    public function getSecondDocumentFile(): ?File
    {
        return $this->secondDocumentFile;
    }

    public function setSecondDocumentFile(?File $secondDocumentFile = null): void
    {
        $this->secondDocumentFile = $secondDocumentFile;

        if (null !== $secondDocumentFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsOnFirst(): ?bool
    {
        return $this->isOnFirst;
    }

    public function setIsOnFirst(?bool $isOnFirst): self
    {
        $this->isOnFirst = $isOnFirst;

        return $this;
    }

}
