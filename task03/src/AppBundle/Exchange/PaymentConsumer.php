<?php
declare(strict_types=1);
namespace AppBundle\Exchange;

use AppBundle\Dto\CalculateDto;
use AppBundle\Dto\PaymentDto;
use AppBundle\Entity\CalculateLog;
use Doctrine\ORM\EntityManager;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class PaymentConsumer implements ConsumerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->em = $entityManager;
    }

    public function execute(AMQPMessage $msg): bool
    {
        /** @var CalculateDto $message */
        $message = unserialize($msg->getBody(), ['allowed_classes' => [CalculateDto::class, PaymentDto::class]]);

        $connection = $this->em->getConnection();
        if ($connection->ping() === false) {
            $connection->close();
            $connection->connect();
        }

        $payments = array_map(function(PaymentDto $paymentDto) {
            return $paymentDto->toArray();
        }, $message->getPayments());

        $entity = new CalculateLog();
        $entity
            ->setMonthlyCosts($message->getMonthlyCosts())
            ->setLoanPeriodMonth($message->getLoanPeriodMonth())
            ->setInterestRate($message->getInterestRate())
            ->setPayments($payments);

        $this->em->persist($entity);
        $this->em->flush($entity);

        // To prevent using cache entities for long time
        $this->em->clear();

        return true;
    }
}
