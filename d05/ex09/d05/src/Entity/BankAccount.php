<?php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'bankAccount', cascade: ['persist', 'remove'])]
    private ?Persons $persons = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersons(): ?Persons
    {
        return $this->persons;
    }

    public function setPersons(?Persons $persons): static
    {
        $this->persons = $persons;

        return $this;
    }
}
