<?php

namespace app\entity;

use app\service\BillGenerator;
use app\service\BillMicroserviceClient;

class Order
{
    const CONTRACTOR_TYPE_PERSON = 1;
    const CONTRACTOR_TYPE_LEGAL = 2;

    public int $id;

    public float $sum;

    public int $contractorType;

    public bool $isPaid;

    public BillGenerator $billGenerator;

    public BillMicroserviceClient $billMicroserviceClient;

    /** @var Item[] */
    public array $items = [];

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPayUrl(): string
    {
        return "http://some-pay-agregator.com/pay/" . $this->id;
    }

    /**
     * @param BillGenerator $billGenerator
     * @return void
     */
    public function setBillGenerator(BillGenerator $billGenerator): void
    {
        $this->billGenerator = $billGenerator;
    }

    /**
     * @return string
     */
    public function getBillUrl(): string
    {
        return $this->billGenerator->generate($this);
    }

    /**
     * @param BillMicroserviceClient $cl
     * @return void
     */
    public function setBillClient(BillMicroserviceClient $cl): void
    {
        $this->billMicroserviceClient = $cl;
    }

    /**
     * @return bool
     */
    public function isPaid():bool
    {
        if ($this->contractorType == self::CONTRACTOR_TYPE_PERSON) {
            return $this->isPaid;
        }
        if ($this->contractorType == self::CONTRACTOR_TYPE_LEGAL) {
            return $this->billMicroserviceClient->IsPaid($this->id);
        }

        return false;
    }
}