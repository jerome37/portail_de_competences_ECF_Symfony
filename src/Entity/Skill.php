<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
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
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="skills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=ProfileSkill::class, mappedBy="skill", orphanRemoval=true)
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $profileSkill->setSkill($this);
        }

        return $this;
    }

    public function removeProfileSkill(ProfileSkill $profileSkill): self
    {
        if ($this->profileSkills->removeElement($profileSkill)) {
            // set the owning side to null (unless already changed)
            if ($profileSkill->getSkill() === $this) {
                $profileSkill->setSkill(null);
            }
        }

        return $this;
    }
}
