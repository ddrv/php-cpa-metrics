<?php

namespace Cpa\Metrics\DTO;

class Ip
{

    /**
     * @var string
     */
    public $address;

    /**
     * @var bool
     */
    public $bot;

    /**
     * @param string $address
     * @param bool $bot
     */
    public function __construct($address = '', $bot = false)
    {
        $this->address = (string)$address;
        $this->bot = (bool)$bot;
    }
}