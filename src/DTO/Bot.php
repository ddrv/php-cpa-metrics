<?php

namespace Cpa\Metrics\DTO;

class Bot
{

    /**
     * @var bool
     */
    public $detected;

    /**
     * @var string
     */
    public $owner;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $name;

    /**
     * @param bool $detected
     * @param string $owner
     * @param string $type
     * @param string $name
     */
    public function __construct($detected = false, $owner = '', $type = '', $name = '')
    {
        $this->detected = (bool)$detected;
        $this->owner = (string)$owner;
        $this->type = (string)$type;
        $this->name = (string)$name;
    }
}