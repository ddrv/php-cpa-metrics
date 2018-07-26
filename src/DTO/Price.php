<?php

namespace Cpa\Metrics\DTO;

class Price
{

    /**
     * @var double
     */
    public $amount;

    /**
     * @var string
     */
    public $currency;

    /**
     * @param double $amount
     * @param string $currency
     */
    public function __construct($amount = 0, $currency = '')
    {
        $this->amount = (double)$amount;
        $this->currency = (string)$currency;
    }
}