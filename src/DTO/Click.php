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
     * @var string
     */
    public $campaign;

    /**
     * @var string
     */
    public $source;

    /**
     * @var string
     */
    public $creative;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var string
     */
    public $request;

    /**
     * @var string
     */
    public $response;

    /**
     * @var string
     */
    public $rule;

    /**
     * @var string
     */
    public $ip;

    /**
     * @var Offer
     */
    public $offer;

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
     * @var bool
     */
    public $unique;

    /**
     * @param void
     */
    public function __construct()
    {
        $this->time = new DateTime();
        $this->device = new Device();
        $this->offer = new Offer();
        $this->os = new Os();
        $this->browser = new Browser();
        $this->geo = new Geo();
        $this->bot = new Bot();
        $this->cost = new Price();
        $this->profit = new Price();
        $this->lead = new Lead();
        $this->tokens = array();
        $this->unique = false;
    }
}