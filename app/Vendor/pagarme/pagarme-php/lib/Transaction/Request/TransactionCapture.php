<?php

namespace PagarMe\Sdk\Transaction\Request;

use PagarMe\Sdk\RequestInterface;

class TransactionCapture implements RequestInterface
{
    /**
     * @var int
     */
    protected $transaction;
    /**
     * @var int
     */
    protected $amount;
    /**
     * @var array
     */
    protected $metadata;

    /**
     * @param PagarMe\Sdk\Transaction\Transaction $transaction
     * @param int $amount
     * @param array $metadata
     */
    public function __construct($transaction, $amount, $metadata = [])
    {
        $this->transaction = $transaction;
        $this->amount = $amount;
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        $payload = [];

        if (!is_null($this->amount)) {
            $payload['amount'] = $this->amount;
        }

        if (!empty($this->metadata)) {
            $payload['metadata'] = $this->metadata;
        }

        return $payload;
    }

    /**
     * @return mixed
     */
    protected function getTransactionId()
    {
        $transactionId = $this->transaction->getId();

        if ($transactionId) {
            return $transactionId;
        }

        return $this->transaction->getToken();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return sprintf('transactions/%s/capture', $this->getTransactionId());
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return self::HTTP_POST;
    }
}
