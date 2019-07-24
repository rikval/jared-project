<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 * @ApiResource()
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message="You must give a name to your contact")
     * @Assert\Length(max="60", maxMessage="The contact's name must be at most {{ limit }} characters.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100", maxMessage="Email must be at most {{ limit }} characters")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max="50", maxMessage="Phone number must be at most {{ limit }} characters")
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max="100", maxMessage="Website must be at most {{ limit }} characters")
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Assert\Length(max="15", maxMessage="Language must be at most {{ limit }} characters")
     */
    private $language;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="contacts")
     */
    private $events;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="contact")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Relation", mappedBy="contact", cascade={"remove"})
     */
    private $relations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="contacts",  cascade={"persist"})
     */
    private $location;



    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->relations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

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

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }

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

    /**
     * @return Collection|Relation[]
     */
    public function getRelations(): Collection
    {
        return $this->relations;
    }

    public function addRelation(Relation $relation): self
    {
        if (!$this->relations->contains($relation)) {
            $this->relations[] = $relation;
            $relation->setContact($this);
        }

        return $this;
    }

    public function removeRelation(Relation $relation): self
    {
        if ($this->relations->contains($relation)) {
            $this->relations->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getContact() === $this) {
                $relation->setContact(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
