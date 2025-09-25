<?php

namespace App\Entity;

use App\Enum\Status;
use App\Repository\PersonsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonsRepository::class)]
class Persons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $enable = null;

    #[ORM\Column]
    private ?\DateTime $birthdate = null;

    #[ORM\Column(enumType: Status::class, nullable:true)]
    private ?Status $marital_status = null;

    #[ORM\OneToOne(mappedBy: 'persons', cascade: ['persist', 'remove'])]
    private ?BankAccount $bankAccount = null;

    #[ORM\ManyToOne(inversedBy: 'persons')]
    private ?Address $address = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): static
    {
        $this->enable = $enable;

        return $this;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTime $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getMaritalStatus(): ?Status
    {
        return $this->marital_status;
    }

    public function setMaritalStatus(Status $marital_status): self
    {
        $this->marital_status = $marital_status;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): static
    {
        // unset the owning side of the relation if necessary
        if ($bankAccount === null && $this->bankAccount !== null) {
            $this->bankAccount->setPersons(null);
        }

        // set the owning side of the relation if necessary
        if ($bankAccount !== null && $bankAccount->getPersons() !== $this) {
            $bankAccount->setPersons($this);
        }

        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

}
