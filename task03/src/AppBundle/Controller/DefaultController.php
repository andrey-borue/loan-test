<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Loan\LoanCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    public function calculateAction(Request $request, SerializerInterface $serializer)
    {
        $loanAmount = (int)$request->request->get('loanAmount');
        $loanPeriod = (int)$request->request->get('loanPeriod');
        $interestRate = (float)$request->request->get('interestRate');
        $firstPaymentDate = $request->request->get('firstPaymentDate');
        $date = \DateTime::createFromFormat('Y-m-d', $firstPaymentDate);

        if (!$loanAmount || !$loanPeriod || !$interestRate || !$date) {
            return new JsonResponse(['error' => 'Error in incoming data.'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $calculator = new LoanCalculator();
        $calculator->setAmountBorrowed($loanAmount);
        $calculator->setInterestRate($interestRate);
        $calculator->setMonths($loanPeriod);
        $calculator->setFirstPaymentDate($date);

        $result = $calculator->calculatePayments();

        $publisher = $this->get('old_sound_rabbit_mq.payment_producer');
        $publisher->publish(serialize($result));


        $json = $serializer->serialize($result, 'json');

        return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
