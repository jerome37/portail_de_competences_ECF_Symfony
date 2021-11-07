<?php

namespace App\Entity;

use App\Repository\ProfileSkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileSkillRepository::class)
 */
class ProfileSkill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $appreciation;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="profileSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="profileSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity=SkillLevel::class, inversedBy="profileSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppreciation(): ?bool
    {
        return $this->appreciation;
    }

    public function setAppreciation(?bool $appreciation): self
    {
        $this->appreciation = $appreciation;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getLevel(): ?SkillLevel
    {
        return $this->level;
    }

    public function setLevel(?SkillLevel $level): self
    {
        $this->level = $level;

        return $this;
    }
}
