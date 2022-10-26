<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: HidingPlace::class)]
    private Collection $hidingPlaces;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Mission::class)]
    private Collection $missions;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Contact::class)]
    private Collection $contacts;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Agent::class)]
    private Collection $agents;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Target::class)]
    private Collection $targets;

    public function __construct()
    {
        $this->hidingPlaces = new ArrayCollection();
        $this->missions = new ArrayCollection();
        $this->contacts = new ArrayCollection();
        $this->agents = new ArrayCollection();
        $this->targets = new ArrayCollection();
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
            $hidingPlace->setCountry($this);
        }

        return $this;
    }

    public function removeHidingPlace(HidingPlace $hidingPlace): self
    {
        if ($this->hidingPlaces->removeElement($hidingPlace)) {
            // set the owning side to null (unless already changed)
            if ($hidingPlace->getCountry() === $this) {
                $hidingPlace->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
            $mission->setCountry($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getCountry() === $this) {
                $mission->setCountry(null);
            }
        }

        return $this;
    }

    public function __toString():string
     {
        return $this->name;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setCountry($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getCountry() === $this) {
                $contact->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->setCountry($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getCountry() === $this) {
                $agent->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTargets(): Collection
    {
        return $this->targets;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->targets->contains($target)) {
            $this->targets->add($target);
            $target->setCountry($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->targets->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getCountry() === $this) {
                $target->setCountry(null);
            }
        }

        return $this;
    }
}
