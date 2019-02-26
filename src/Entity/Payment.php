<?php

namespace Cpa\Metrics\Entity;

use DateTime;
use Exception;

final class Payment
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $time;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var float
     */
    private $amount;

    public function __construct()
    {
        $this->id = '';
        $this->time = DateTime::createFromFormat('U', 0);
        $this->amount = 0.0;
        $this->currency = 'USD';
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $id
     * @return self
     * @throws Exception
     */
    public function setId($id)
    {
        if (!is_string($id)) {
            throw new Exception('parameter id must be an a string');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @param DateTime $time
     * @return self
     * @throws Exception
     */
    public function setTime(DateTime $time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @param string $currency
     * @return self
     * @throws Exception
     */
    public function setCurrency($currency)
    {
        if (!is_string($currency)) {
            throw new Exception('parameter currency must be an a string');
        }
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param float $amount
     * @return self
     * @throws Exception
     */
    public function setAmount($amount)
    {
        if (!is_numeric($amount)) {
            throw new Exception('parameter amount must be an a numeric');
        }
        $this->amount = (float)$amount;
        return $this;
    }
}