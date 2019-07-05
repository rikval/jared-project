<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="You must give a date to your event")
     */
    private $dateEvent;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $startHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $endHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $arrivalHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $allowance;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasAccommodation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Venue", inversedBy="event")
     */
    private $venue;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contact", mappedBy="events")
     */
    private $contacts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tour", inversedBy="shows")
     */
    private $tour;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getStartHour(): ?\DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(?\DateTimeInterface $startHour): self
    {
        $this->startHour = $startHour;

        return $this;
    }

    public function getEndHour(): ?\DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(?\DateTimeInterface $endHour): self
    {
        $this->endHour = $endHour;

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
}
