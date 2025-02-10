<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationality = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currentLocation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $placeOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?bool $availibility = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\ManyToOne]
    private ?Gender $gender = null;

    #[ORM\ManyToOne]
    private ?JobCategory $jobCategory = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[Vich\UploadableField(mapping: 'passport', fileNameProperty: 'passportFilename')]
    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'])]
    private ?File $passportFile = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $passportFilename = null;

    #[Vich\UploadableField(mapping: 'curriculumvitae', fileNameProperty: 'curriculumvitaeFilename')]
    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'])]
    private ?File $curriculumVitaeFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $curriculumVitaeFilename = null;

    #[Vich\UploadableField(mapping: 'profilePicture', fileNameProperty: 'profilePictureFilename')]
    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png'])]
    private ?File $profilePictureFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePictureFilename = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $experience = null;

    #[ORM\OneToOne(inversedBy: 'candidate', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;


    public function _construct(){
        $this->createdAt = new \DateTimeImmutable();
    }


    
    public function getProfilePictureFile(): ?File
    {
        return $this->profilePictureFile;
    }

    public function setProfilePictureFile(?File $profilePictureFile): self
    {
        $this->profilePictureFile = $profilePictureFile;

        if (null !== $profilePictureFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getCurriculumVitaeFile(): ?File
    {
        return $this->curriculumVitaeFile;
    }

    public function setCurriculumVitaeFile(?File $curriculumVitaeFile): self
    {
        $this->curriculumVitaeFile = $curriculumVitaeFile;
        if (null !== $curriculumVitaeFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getPassportFile(): ?File
    {
        return $this->passportFile;
    }

    public function setPassportFile(?File $passportFile): self
    {
        $this->passportFile = $passportFile;

        if (null !== $passportFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getCurrentLocation(): ?string
    {
        return $this->currentLocation;
    }

    public function setCurrentLocation(?string $currentLocation): static
    {
        $this->currentLocation = $currentLocation;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    public function setPlaceOfBirth(?string $placeOfBirth): static
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): static
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function isAvailibility(): ?bool
    {
        return $this->availibility;
    }

    public function setAvailibility(?bool $availibility): static
    {
        $this->availibility = $availibility;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getJobCategory(): ?JobCategory
    {
        return $this->jobCategory;
    }

    public function setJobCategory(?JobCategory $jobCategory): static
    {
        $this->jobCategory = $jobCategory;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPassportFilename(): ?string
    {
        return $this->passportFilename;
    }

    public function setPassportFilename(?string $passportFilename): static
    {
        $this->passportFilename = $passportFilename;

        return $this;
    }

    public function getCurriculumVitaeFilename(): ?string
    {
        return $this->curriculumVitaeFilename;
    }

    public function setCurriculumVitaeFilename(?string $curriculumVitaeFilename): static
    {
        $this->curriculumVitaeFilename = $curriculumVitaeFilename;

        return $this;
    }

    public function getProfilePictureFilename(): ?string
    {
        return $this->profilePictureFilename;
    }

    public function setProfilePictureFilename(?string $profilePictureFilename): static
    {
        $this->profilePictureFilename = $profilePictureFilename;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
