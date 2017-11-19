<?php

namespace AppBundle\Controller;

use AppBundle\Loan\LoanCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    public function calculateAction(Request $request)
    {
        $loanAmount = (int)$request->request->get('loan_amount');
        $loanPeriod = (int)$request->request->get('loan_period');
        $interestRate = (float)$request->request->get('interest_rate');
        $firstPaymentDate = $request->request->get('first_payment_date');
        $date = \DateTime::createFromFormat('Y-m-d', $firstPaymentDate);

        if (!$loanAmount || !$loanPeriod || !$interestRate || !$date) {
            return new JsonResponse(['error' => 'Error in incoming data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $calculator = new LoanCalculator();
        $calculator->setAmountBorrowed($loanAmount);
        $calculator->setInterestRate($interestRate);
        $calculator->setMonths($loanPeriod);
        $calculator->setFirstPaymentDate($date);

        return new JsonResponse([
            'loan_amount' => $loanAmount,
            'loan_period_month' => $loanPeriod,
            'interest_rate' => $interestRate,
            'monthly_costs' => $calculator->calculateRepayment(),
            'payments' => $calculator->calculatePayments()
        ]);
    }
}
