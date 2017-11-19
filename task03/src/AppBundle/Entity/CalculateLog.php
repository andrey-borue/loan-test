<?php
declare(strict_types=1);
namespace AppBundle\Entity;

class CalculateLog
{
    /** @var int */
    private $id;
    /** @var float */
    private $interestRate;
    /** @var int */
    private $loanPeriodMonth;
    /** @var float */
    private $monthlyCosts;
    /** @var array */
    private $payments; // Yes, $payments can be collection of other Entity

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(?float $interestRate): self
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getLoanPeriodMonth(): ?int
    {
        return $this->loanPeriodMonth;
    }

    public function setLoanPeriodMonth(?int $loanPeriodMonth): self
    {
        $this->loanPeriodMonth = $loanPeriodMonth;

        return $this;
    }

    public function getMonthlyCosts(): ?float
    {
        return $this->monthlyCosts;
    }

    public function setMonthlyCosts(?float $monthlyCosts): self
    {
        $this->monthlyCosts = $monthlyCosts;

        return $this;
    }

    public function getPayments(): array
    {
        return $this->payments;
    }

    public function setPayments(array $payments)
    {
        $this->payments = $payments;

        return $this;
    }
}
