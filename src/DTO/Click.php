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
     * @var Bot
     */
    public $bot;

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
     * @var string[]
     */
    public $tokens;

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
        $this->bot = new Bot();
        $this->cost = new Price();
        $this->profit = new Price();
        $this->lead = new Lead();
        $this->tokens = array();

    }
}