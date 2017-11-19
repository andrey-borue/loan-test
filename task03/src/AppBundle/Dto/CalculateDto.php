<?php
declare(strict_types=1);

namespace AppBundle\Dto;

class CalculateDto
{
    /** @var float */
    private $loanAmount;
    /** @var int */
    private $loanPeriodMonth;
    /** @var  float */
    private $interestRate;
    /** @var float */
    private $monthlyCosts;
    /** @var PaymentDto[] */
    private $payments;

    public function getLoanAmount(): ?float
    {
        return $this->loanAmount;
    }

    public function setLoanAmount(?float $loanAmount): self
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    public function getLoanPeriodMonth(): ?int
    {
        return $this->loanPeriodMonth;
    }

    public function setLoanPeriodMonth(?int $loanPeriodMonth)
    {
        $this->loanPeriodMonth = $loanPeriodMonth;

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

    public function getMonthlyCosts(): ?float
    {
        return $this->monthlyCosts;
    }

    public function setMonthlyCosts(?float $monthlyCosts): self
    {
        $this->monthlyCosts = $monthlyCosts;

        return $this;
    }

    /**
     * @return PaymentDto[]
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    public function setPayments(PaymentDto ...$payments): self
    {
        foreach ($payments as $payment) {
            $this->addPayment($payment);
        }

        return $this;
    }

    public function addPayment(PaymentDto $paymentDto): self
    {
        $this->payments[] = $paymentDto;

        return $this;
    }

    public function createPayment(): PaymentDto
    {
        $payment = new PaymentDto();

        $this->addPayment($payment);

        return $payment;
    }
}