<?php

namespace Cpa\Metrics\DTO;

class Offer
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $network;

    /**
     * @param string $id
     * @param string $network
     * @param string $category
     */
    public function __construct($id = '', $category='', $network='') {
        $this->id = (string)$id;
        $this->category = (string)$category;
        $this->network = (string)$network;
    }
}