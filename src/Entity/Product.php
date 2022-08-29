<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="product")
     */
    private $idcaegory;

    public function __construct()
    {
        $this->idcaegory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(?bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getIdcaegory(): Collection
    {
        return $this->idcaegory;
    }

    public function addIdcaegory(Category $idcaegory): self
    {
        if (!$this->idcaegory->contains($idcaegory)) {
            $this->idcaegory[] = $idcaegory;
            $idcaegory->setProduct($this);
        }

        return $this;
    }

    public function removeIdcaegory(Category $idcaegory): self
    {
        if ($this->idcaegory->removeElement($idcaegory)) {
            // set the owning side to null (unless already changed)
            if ($idcaegory->getProduct() === $this) {
                $idcaegory->setProduct(null);
            }
        }

        return $this;
    }

}
