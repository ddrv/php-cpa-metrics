<?php

namespace Cpa\Metrics\DTO;

class Geo
{

    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $area;

    /**
     * @var string
     */
    public $city;

    /**
     * @param string $country
     * @param string $area
     * @param string $city
     */
    public function __construct($country = '', $area = '', $city = '')
    {
        $this->country = (string)$country;
        $this->area = (string)$area;
        $this->city = (string)$city;
    }
}