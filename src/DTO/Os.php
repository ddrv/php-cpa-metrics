<?php

namespace Cpa\Metrics\DTO;

class Os
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $version;

    /**
     * @param string $name
     * @param string $version
     */
    public function __construct($name = '', $version = '')
    {
        $this->name = (string)$name;
        $this->version = (string)$version;
    }
}