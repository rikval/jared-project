<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RelationRepository")
 * @ApiResource()
 */
class Relation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="relations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="You must chose an artist to build a relation")
     *
     */
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="relations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="You must chose a contact to build a relation")
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="You must characterize the relation to build it")
     *
     */
    private $affinity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAffinity(): ?string
    {
        return $this->affinity;
    }

    public function setAffinity(string $affinity): self
    {
        $this->affinity = $affinity;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
