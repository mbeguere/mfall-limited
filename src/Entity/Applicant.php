<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicantRepository")
 * @Vich\Uploadable
 */
class Applicant extends User
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $resume;

    /**
     * @Vich\UploadableField(mapping="resume_images", fileNameProperty="resume")
     * @var File
     */
    private $resumeFile;

     /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $postalCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="applicants")
     * @Assert\NotBlank
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Job", inversedBy="applicants")
     */
    private $job;

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setResumeFile(File $resume = null)
    {
        $this->resumeFile = $resume;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($resume) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->createdAt = new \DateTime('now');
        }
    }

    public function getResumeFile()
    {
        return $this->resumeFile;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }
}
