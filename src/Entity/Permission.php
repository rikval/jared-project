<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PermissionRepository")
 * @ApiResource()
 */
class Permission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank(message="Wich level of permission do you want to give ?")
     */
    private $permission;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="permissions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var string
     * @Assert\NotBlank(message="Please enter a UserTag")
     */
    private $userTag;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tour", inversedBy="permissions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="You must chose a tour")
     */
    private $tour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPermission(): ?string
    {
        return $this->permission;
    }

    public function setPermission(string $permission): self
    {
        $this->permission = $permission;

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
     * @return string
     */
    public function getUserTag(): ?string
    {
        return $this->userTag;
    }/**
     * @param string $userTag
     * @return Permission
     */
    public function setUserTag(?string $userTag): Permission
    {
        $this->userTag = $userTag;
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
