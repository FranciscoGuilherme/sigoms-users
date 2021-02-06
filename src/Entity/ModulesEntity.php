<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="modules")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ModulesRepository")
 */
class ModulesEntity
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private string $route;

    /**
     * @ORM\Column(type="string", length=25, unique=true, name="`image_name`")
     */
    private string $imageName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $description;

    /**
     * @ORM\Column(type="string", length=100, name="`user_role`", nullable=true)
     */
    private string $userRole;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getImageName(): string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserRole(): string
    {
        return $this->userRole;
    }

    public function setUserRole(string $userRole): self
    {
        $this->userRole = $userRole;

        return $this;
    }
}