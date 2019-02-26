<?php

namespace Cpa\Metrics\Entity;

use DateTime;
use DateTimeZone;
use Exception;

final class Click
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     */
    private $time;

    /**
     * @var bool
     */
    private $isLead;

    /**
     * @var string
     */
    private $status;

    /**
     * @var float
     */
    private $nominalCost;

    /**
     * @var float
     */
    private $nominalProfit;

    /**
     * @var Payment[]
     */
    private $costHistory = array();

    /**
     * @var Payment[]
     */
    private $profitHistory = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     * @throws Exception
     */
    public function setId($id)
    {
        if (!is_int($id)) {
            throw new Exception('parameter id must be an a integer');
        }
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param DateTime $time
     * @return self
     */
    public function setTime(DateTime $time)
    {
        $time->setTimezone(new DateTimeZone('UTC'));
        $this->time = $time;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLead()
    {
        return $this->isLead;
    }

    /**
     * @param bool $lead
     * @return self
     */
    public function setLead($lead)
    {
        $this->isLead = (bool)$lead;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return self
     * @throws Exception
     */
    public function setStatus($status)
    {
        if (!is_string($status)) {
            throw new Exception('parameter status must be an a string');
        }
        $this->status = $status;
        return $this;
    }

    /**
     * @return float
     */
    public function getNominalCost()
    {
        return $this->nominalCost;
    }

    /**
     * @param float $nominalCost
     * @return self
     * @throws Exception
     */
    public function setNominalCost($nominalCost)
    {
        if (!is_numeric($nominalCost)) {
            throw new Exception('parameter nominalCost must be an a numeric');
        }
        $this->nominalCost = $nominalCost;
        return $this;
    }

    /**
     * @return float
     */
    public function getNominalProfit()
    {
        return $this->nominalProfit;
    }

    /**
     * @param float $nominalProfit
     * @return self
     * @throws Exception
     */
    public function setNominalProfit($nominalProfit)
    {
        if (!is_numeric($nominalProfit)) {
            throw new Exception('parameter nominalProfit must be an a numeric');
        }
        $this->nominalProfit = $nominalProfit;
        return $this;
    }
}