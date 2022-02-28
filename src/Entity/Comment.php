<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="blog_alameda_comment")
 *
 * Defines the properties of the Comment entity to represent the blog comments.
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate this entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Gerardo J. Montivero <gerardo.montivero@gmail.com>
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Post $post;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="comment.blank")
     * @Assert\Length(
     *     min=5,
     *     minMessage="comment.too_short",
     *     max=5000,
     *     maxMessage="comment.too_long"
     * )
     */
    private string $content;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private DateTime $publishedAt;


    /**
     * @ORM\Column(type="string", length=255, nullable=true, options={"default" = "submitted"})
     */
    private ?string $state = 'submitted';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $moderatedAt;

    /**
     * @ORM\OneToOne(targetEntity=User::class)
     */
    private ?User $moderatedBy;


    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?DateTimeImmutable $moderatedNoticeAt;

    public function __construct()
    {
        $this->publishedAt = new DateTime();
    }

    /**
     * @Assert\IsTrue(message="comment.is_spam")
     */
    public function isLegitComment(): bool
    {
        $containsInvalidCharacters = null !== u($this->content)->indexOf('@');

        return !$containsInvalidCharacters;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getPublishedAt(): DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTime $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getModeratedAt(): ?DateTimeImmutable
    {
        return $this->moderatedAt;
    }

    public function setModeratedAt(?DateTimeImmutable $moderatedAt): self
    {
        $this->moderatedAt = $moderatedAt;

        return $this;
    }

    public function getModeratedBy(): ?User
    {
        return $this->moderatedBy;
    }

    public function setModeratedBy(?User $moderatedBy): self
    {
        $this->moderatedBy = $moderatedBy;

        return $this;
    }

    public function getModeratedNoticeAt(): ?DateTimeImmutable
    {
        return $this->moderatedNoticeAt;
    }

    public function setModeratedNoticeAt(?DateTimeImmutable $moderatedNoticeAt): self
    {
        $this->moderatedNoticeAt = $moderatedNoticeAt;

        return $this;
    }
}
