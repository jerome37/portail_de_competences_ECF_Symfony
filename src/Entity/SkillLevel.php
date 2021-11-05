<?php

namespace App\Entity;

use App\Repository\SkillLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillLevelRepository::class)
 */
class SkillLevel
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
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=ProfileSkill::class, mappedBy="level", orphanRemoval=true)
     */
    private $profileSkills;

    public function __construct()
    {
        $this->profileSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|ProfileSkill[]
     */
    public function getProfileSkills(): Collection
    {
        return $this->profileSkills;
    }

    public function addProfileSkill(ProfileSkill $profileSkill): self
    {
        if (!$this->profileSkills->contains($profileSkill)) {
            $this->profileSkills[] = $profileSkill;
            $profileSkill->setLevel($this);
        }

        return $this;
    }

    public function removeProfileSkill(ProfileSkill $profileSkill): self
    {
        if ($this->profileSkills->removeElement($profileSkill)) {
            // set the owning side to null (unless already changed)
            if ($profileSkill->getLevel() === $this) {
                $profileSkill->setLevel(null);
            }
        }

        return $this;
    }
}
