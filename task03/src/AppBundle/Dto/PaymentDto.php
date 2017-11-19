<?php
declare(strict_types=1);

namespace AppBundle\Dto;

class PaymentDto
{
    /** @var  int */
    private $id;
    /** @var string */
    private $date;
    /** @var float */
    private $percent;
    /** @var float */
    private $debt;
    /** @var float */
    private $balance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPercent(): ?float
    {
        return $this->percent;
    }

    public function setPercent(?float $percent): self
    {
        $this->percent = $percent;

        return $this;
    }

    public function getDebt(): ?float
    {
        return $this->debt;
    }

    public function setDebt(?float $debt)
    {
        $this->debt = $debt;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(?float $balance)
    {
        $this->balance = $balance;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'percent' => $this->getPercent(),
            'balance' => $this->getBalance()
        ];
    }
}