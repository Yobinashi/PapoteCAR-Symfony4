<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\member", inversedBy="comments")
     */
    private $writer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\member", inversedBy="commentsaboutme")
     * @ORM\JoinColumn(nullable=false)
     */
    private $target;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function getWriter(): ?member
    {
        return $this->writer;
    }

    public function setWriter(?member $writer): self
    {
        $this->writer = $writer;

        return $this;
    }

    public function getTarget(): ?member
    {
        return $this->target;
    }

    public function setTarget(?member $target): self
    {
        $this->target = $target;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

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
}
