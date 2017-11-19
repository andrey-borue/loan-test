<?php
namespace AppBundle\Loan;

class LoanCalculator {

    private $amountBorrowed = 0;
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

    public function calculatePayments(): array
    {
        $result = [];
        $repayment = $this->calculateRepayment();
        $date = $this->firstPaymentDate;
        $debt = 0;
        $balance = $this->amountBorrowed;
        for($i = 1; $i <= $this->months; $i++) {
            $balance -= $debt;
            $percent = $balance * $this->interestRate / 12;
            $debt = round($repayment - $percent, 2);
            $result[] = [
                'id' => $i,
                'date' => $date->format('Y-m-d'),
                'percent' => round($percent, 2),
                'debt' => round($debt, 2),
                'balance' => round($balance, 2),
            ];
            $date = $date->modify('+1 month');
        }

        return $result;

    }

    public function setFirstPaymentDate(\DateTimeInterface $firstPaymentDate): self
    {
        $this->firstPaymentDate = $firstPaymentDate;

        return $this;
    }

    public function setAmountBorrowed(int $amount ): self
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