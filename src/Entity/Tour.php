<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TourRepository")
 * @ApiResource()
 */
class Tour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="You must give a name to your tour")
     * @Assert\Length(max="50", maxMessage="Tour's name must be at most {{ limit }} characters")
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Please enter a Begin Date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Please enter a End date")
     */
    private $endDate;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Permission", mappedBy="tour", orphanRemoval=true)
     */
    private $permissions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="tours")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="You must choose an artist")
     */
    private $artist;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="tour", orphanRemoval=true)
     */
    private $events;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->setStartDate(new \DateTime('now'));
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }


    /**
     * @return Collection|Permission[]
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions[] = $permission;
            $permission->setTour($this);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        if ($this->permissions->contains($permission)) {
            $this->permissions->removeElement($permission);
            // set the owning side to null (unless already changed)
            if ($permission->getTour() === $this) {
                $permission->setTour(null);
            }
        }

        return $this;
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
            $event->setTour($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getTour() === $this) {
                $event->setTour(null);
            }
        }
        return $this;
    }
}
