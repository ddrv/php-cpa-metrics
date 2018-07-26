<?php

namespace Cpa\Metrics\DTO;

class Device
{

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $vendor;

    /**
     * @var string
     */
    public $model;

    /**
     * @var bool
     */
    public $bot;

    /**
     * @param string $type
     * @param string $vendor
     * @param string $model
     * @param bool $bot
     */
    public function __construct($type = '', $vendor = '', $model = '', $bot = false)
    {
        $this->type = (string)$type;
        $this->vendor = (string)$vendor;
        $this->model = (string)$model;
        $this->bot = (bool)$bot;
    }
}