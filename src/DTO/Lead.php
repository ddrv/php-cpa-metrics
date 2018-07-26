<?php

namespace Cpa\Metrics\DTO;

class Lead
{

    /**
     * @var bool
     */
    public $lead;

    /**
     * @var string
     */
    public $status;

    /**
     * @param bool $lead
     * @param string $status
     */
    public function __construct($lead = false, $status = '')
    {
        $this->lead = (bool)$lead;
        $this->status = (string)$status;
    }
}