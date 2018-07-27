<?php

namespace Cpa\Metrics\DTO;

class Traffic
{

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
    public $offer;

    /**
     * @param string $campaign
     * @param string $source
     * @param string $creative
     * @param string $keyword
     * @param string $request
     * @param string $response
     * @param string $rule
     * @param string $offer
     */
    public function __construct(
        $campaign = '',
        $source='',
        $creative='',
        $keyword='',
        $request = '',
        $response = '',
        $rule = '',
        $offer = ''
    ) {
        $this->campaign = (string)$campaign;
        $this->source = (string)$source;
        $this->creative = (string)$creative;
        $this->keyword = (string)$keyword;
        $this->request = (string)$request;
        $this->response = (string)$response;
        $this->rule = (string)$rule;
        $this->offer = (string)$offer;
    }
}