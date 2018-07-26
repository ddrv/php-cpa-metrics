<?php

namespace Cpa\Metrics\DTO;

use DateTime;

class Click
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var DateTime
     */
    public $time;

    /**
     * @var Traffic
     */
    public $traffic;

    /**
     * @var Device
     */
    public $device;

    /**
     * @var Os
     */
    public $os;

    /**
     * @var Browser
     */
    public $browser;

    /**
     * @var Geo
     */
    public $geo;

    /**
     * @var Ip
     */
    public $ip;

    /**
     * @var Price
     */
    public $cost;

    /**
     * @var Price
     */
    public $profit;

    /**
     * @var Lead
     */
    public $lead;

    /**
     * @param void
     */
    public function __construct()
    {
        $this->time = new DateTime();
        $this->traffic = new Traffic();
        $this->device = new Device();
        $this->os = new Os();
        $this->browser = new Browser();
        $this->geo = new Geo();
        $this->ip = new Ip();
        $this->cost = new Price();
        $this->profit = new Price();
        $this->lead = new Lead();

    }
}