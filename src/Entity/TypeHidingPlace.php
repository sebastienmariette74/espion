<?php

namespace App\Entity;

use App\Repository\TypeHidingPlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeHidingPlaceRepository::class)]
class TypeHidingPlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: HidingPlace::class)]
    private Collection $hidingPlaces;

    public function __construct()
    {
        $this->hidingPlaces = new ArrayCollection();
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

    /**
     * @return Collection<int, HidingPlace>
     */
    public function getHidingPlaces(): Collection
    {
        return $this->hidingPlaces;
    }

    public function addHidingPlace(HidingPlace $hidingPlace): self
    {
        if (!$this->hidingPlaces->contains($hidingPlace)) {
            $this->hidingPlaces->add($hidingPlace);
            $hidingPlace->setType($this);
        }

        return $this;
    }

    public function removeHidingPlace(HidingPlace $hidingPlace): self
    {
        if ($this->hidingPlaces->removeElement($hidingPlace)) {
            // set the owning side to null (unless already changed)
            if ($hidingPlace->getType() === $this) {
                $hidingPlace->setType(null);
            }
        }

        return $this;
    }
}
