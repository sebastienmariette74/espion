<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

// use Symfony\Component\Validator\Mapping\ClassMetadata;


#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $codeName = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMission $type = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatusMission $status = null;

    #[ORM\ManyToOne(inversedBy: 'missions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Speciality $speciality = null;
    
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $finish_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $begin_at = null;

    #[ORM\ManyToMany(targetEntity: HidingPlace::class, inversedBy: 'missions')]
    private Collection $hidingPlace;

    #[ORM\ManyToMany(targetEntity: Agent::class, inversedBy: 'missions')]
    private Collection $agent;

    #[ORM\ManyToMany(targetEntity: Target::class, inversedBy: 'missions')]
    private Collection $target;

    #[ORM\ManyToMany(targetEntity: Contact::class, inversedBy: 'missions')]
    private Collection $contact;

    public function __construct()
    {
        $this->hidingPlace = new ArrayCollection();
        $this->agent = new ArrayCollection();
        $this->target = new ArrayCollection();
        $this->contact = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    public function setCodeName(string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getType(): ?TypeMission
    {
        return $this->type;
    }

    public function setType(?TypeMission $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?StatusMission
    {
        return $this->status;
    }

    public function setStatus(?StatusMission $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection<int, HidingPlace>
     */
    public function getHidingPlace(): Collection
    {
        return $this->hidingPlace;
    }

    public function addHidingPlace(HidingPlace $hidingPlace): self
    {
        if (!$this->hidingPlace->contains($hidingPlace)) {
            $this->hidingPlace->add($hidingPlace);
        }

        return $this;
    }

    public function removeHidingPlace(HidingPlace $hidingPlace): self
    {
        $this->hidingPlace->removeElement($hidingPlace);

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent->add($agent);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        $this->agent->removeElement($agent);

        return $this;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTarget(): Collection
    {
        return $this->target;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target->add($target);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        $this->target->removeElement($target);

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact->add($contact);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        $this->contact->removeElement($contact);

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }


    public function getFinishAt(): ?\DateTimeImmutable
    {
        return $this->finish_at;
    }

    public function setFinishAt(?\DateTimeImmutable $finish_at): self
    {
        $this->finish_at = $finish_at;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeInterface
    {
        return $this->begin_at;
    }

    public function setBeginAt(\DateTimeInterface $begin_at): self
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Assert\Callback('validate'));
    }

    public function validate(ExecutionContextInterface $context, $payload)
    {

        if ($this->getTarget() ){
            
            $targets = $this->getTarget();
            $countriesTarget = [];
            foreach ($targets as $target) {
                $country = $target->getCountry()->getName();
                    $countriesTarget[] = $country;
            }
            $agents = $this->getAgent();
            $countriesAgent = [];
            foreach ($agents as $agent) {
                $country = $agent->getCountry()->getName();
                $countriesAgent[] = $country;
            }
            foreach ($countriesTarget as $countriyTarget) {
                if (in_array($countriyTarget, $countriesAgent)) {
                    $context->buildViolation('Les agents ne peuvent pas avoir la même nationalité que les cibles.')
                        ->atPath('agent')
                        ->addViolation();
                }            
            }
        }


        if ($this->getSpeciality()) {
            $agents = $this->getAgent();
            
            $tab = [];
            foreach ($agents as $agent) {
                $specialities = $agent->getSpeciality();
                foreach ($specialities as $speciality) {
                    $specialityName = $speciality->getName();
                    $tab[] = $specialityName;
                }
            }

            $country = $this->getCountry()->getName();
            
            $speciality = $this->getSpeciality()->getName();

            if (!in_array($speciality, $tab)) {

                $speciality = strtoupper($speciality);
                $context->buildViolation('Vous devez choisir au moins 1 agent avec la spécialité ' . $speciality)
                    ->atPath('agent')
                    ->addViolation();
            }           
          
        }
        if ($this->getCodeName() === ""){
            $context->buildViolation('Vous devez choisir un nom de code')
                ->atPath('codeName')
                ->addViolation();
        }

        if ($this->getStatus() === null){
            $context->buildViolation('Vous devez choisir un statut')
                ->atPath('status')
                ->addViolation();
        }
        if ($this->getType() === null){
            $context->buildViolation('Vous devez choisir un type')
                ->atPath('type')
                ->addViolation();
        }
        if ($this->getContact() === null){
            $context->buildViolation('Vous devez choisir un contact')
                ->atPath('contact')
                ->addViolation();
        }
    }
}
