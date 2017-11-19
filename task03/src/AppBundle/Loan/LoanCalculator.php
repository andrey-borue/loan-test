<?php
declare(strict_types=1);
namespace AppBundle\Loan;

use AppBundle\Dto\CalculateDto;

class LoanCalculator {

    private $amountBorrowed = 0.0;
    private $interestRate = 0.0;
    private $months = 0;
    /** @var  \DateTime */
    private $firstPaymentDate;

    public function calculateInterestOnlyPayment(): float
    {
        $payment = ( $this->amountBorrowed * $this->interestRate ) / 12;

        return round($payment,2);
    }

    public function calculateRepayment(): float
    {
        $P = $this->interestRate / 12;
        $payment = $this->amountBorrowed * ($P + $P / ((1 + $P)**$this->months - 1));

        return round($payment,2);
    }

    public function calculatePayments(): CalculateDto
    {
        $result = new CalculateDto();
        $result
            ->setInterestRate($this->interestRate)
            ->setLoanAmount($this->amountBorrowed)
            ->setLoanPeriodMonth($this->months)
            ->setMonthlyCosts($this->calculateRepayment());


        $repayment = $this->calculateRepayment();
        $date = $this->firstPaymentDate;
        $debt = 0;
        $balance = $this->amountBorrowed;
        for($i = 1; $i <= $this->months; $i++) {
            $balance -= $debt;
            $percent = $balance * $this->interestRate / 12;
            $debt = round($repayment - $percent, 2);
            $result->createPayment()
                ->setId($i)
                ->setPercent(round($percent, 2))
                ->setDate($date->format('Y-m-d'))
                ->setDebt(round($debt, 2))
                ->setBalance(round($balance, 2));
            $date = $date->modify('+1 month');
        }

        return $result;

    }

    public function setFirstPaymentDate(\DateTimeInterface $firstPaymentDate): self
    {
        $this->firstPaymentDate = $firstPaymentDate;

        return $this;
    }

    public function setAmountBorrowed(float $amount ): self
    {
        $this->amountBorrowed = $amount;

        return $this;
    }

    public function setInterestRate(float $rate ): self
    {
        $this->interestRate = $rate / 100;

        return $this;
    }

    public function setMonths(int $months): self
    {
        $this->months = $months;

        return $this;
    }
}