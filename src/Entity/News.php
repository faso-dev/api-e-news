<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     shortName="feeds",
 *     itemOperations={"get"},
 *     collectionOperations={"get", "post"},
 *     normalizationContext={"groups"={"news:read"}},
 *     denormalizationContext={"groups"={"news:write"}},
 *     attributes={"pagination_items_per_page"=1}
 * )
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "title": "ipartial"})
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"news:read", "news:write"})
     * @Assert\NotNull(message="Le titre ne peut être nul")
     * @Assert\Length(
     *     min="5",
     *     max="225",
     *     minMessage="Le titre doit avoir au minimun 5 caractères",
     *     maxMessage="Le titre ne doit excéder les 255 caratères"
     * )
     * @SerializedName("moi")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"news:read", "news:write"})
     * @Assert\NotNull(message="Le contenu du news ne peut être vide")
     * @Assert\Length(
     *     min="10",
     *     maxMessage="1000",
     *     minMessage="Le contenu doit au minimum avoir 10 caratères",
     *     maxMessage="Le contenu ne doit excéder les 1 000 caractères"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"news:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"news:read"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
