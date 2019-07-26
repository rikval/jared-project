<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ApiResource(
 *     normalizationContext={"groups"={"events:read"}}
 * )
 *
 * @ApiFilter(BooleanFilter::class, properties={"isPublic"})
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"events:read"})
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message="Please enter a Title")
     * @Assert\Length(max="50", maxMessage="Event's title must be at most {{ limit }} characters")
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Please enter a start hour")
     */
    private $beginAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $arrivalHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $allowance;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $currency = '€';

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasAccommodation = true;

    /**
     * @ORM\Column(type="boolean")
     *
     */
    private $isPublic = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Venue", inversedBy="event",  cascade={"remove"})
     * @Groups({"events:read"})
     */
    private $venue;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contact", mappedBy="events")
     */
    private $contacts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tour", inversedBy="events")
     */
    private $tour;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="events")
     */
    private $users;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->beginAt;
    }

    public function setBeginAt(?\DateTimeInterface $beginAt): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getArrivalHour(): ?\DateTimeInterface
    {
        return $this->arrivalHour;
    }

    public function setArrivalHour(?\DateTimeInterface $arrivalHour): self
    {
        $this->arrivalHour = $arrivalHour;

        return $this;
    }

    public function getAllowance(): ?int
    {
        return $this->allowance;
    }

    public function setAllowance(?int $allowance): self
    {
        $this->allowance = $allowance;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getHasAccommodation(): ?bool
    {
        return $this->hasAccommodation;
    }

    public function setHasAccommodation(?bool $hasAccommodation): self
    {
        $this->hasAccommodation = $hasAccommodation;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getVenue(): ?Venue
    {
        return $this->venue;
    }

    public function setVenue(?Venue $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->addEvent($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            $contact->removeEvent($this);
        }

        return $this;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addEvent($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeEvent($this);
        }

        return $this;
    }
}
