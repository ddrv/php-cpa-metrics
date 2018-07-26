<?php

namespace Cpa\Metrics\DTO;

class Browser
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
     * @var string
     */
    public $engine;

    /**
     * @param string $name
     * @param string $version
     * @param string $engine
     */
    public function __construct($name = '', $version = '', $engine = '')
    {
        $this->name = (string)$name;
        $this->version = (string)$version;
        $this->engine = (string)$engine;
    }
}