<?php

namespace Cpa\Metrics\Entity;

use DateTime;
use DateTimeZone;
use Exception;

final class Traffic
{

    /**
     * @var string
     */
    private $campaign;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $creative;

    /**
     * @var string
     */
    private $keyword;

    /**
     * @var bool
     */
    private $isUnique;

    /**
     * @var string
     */
    private $rule;

    /**
     * @var string
     */
    private $request;

    /**
     * @var string
     */
    private $response;

    /**
     * @return string
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param string $campaign
     * @return self
     * @throws Exception
     */
    public function setCampaign($campaign)
    {
        if (!is_string($campaign)) {
            throw new Exception('parameter campaign must be an a string');
        }
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return self
     * @throws Exception
     */
    public function setSource($source)
    {
        if (!is_string($source)) {
            throw new Exception('parameter source must be an a string');
        }
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreative()
    {
        return $this->creative;
    }

    /**
     * @param string $creative
     * @return self
     * @throws Exception
     */
    public function setCreative($creative)
    {
        if (!is_string($creative)) {
            throw new Exception('parameter creative must be an a string');
        }
        $this->creative = $creative;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     * @return self
     * @throws Exception
     */
    public function setKeyword($keyword)
    {
        if (!is_string($keyword)) {
            throw new Exception('parameter keyword must be an a string');
        }
        $this->keyword = $keyword;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->isUnique;
    }

    /**
     * @param bool $unique
     * @return self
     */
    public function setUnique($unique)
    {
        $this->isUnique = (bool)$unique;
        return $this;
    }

    /**
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * @param string $rule
     * @return self
     * @throws Exception
     */
    public function setRule($rule)
    {
        if (!is_string($rule)) {
            throw new Exception('parameter rule must be an a string');
        }
        $this->rule = $rule;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $request
     * @return self
     * @throws Exception
     */
    public function setRequest($request)
    {
        if (!is_string($request)) {
            throw new Exception('parameter request must be an a string');
        }
        $this->request = $request;
        return $this;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     * @return self
     * @throws Exception
     */
    public function setResponse($response)
    {
        if (!is_string($response)) {
            throw new Exception('parameter response must be an a string');
        }
        $this->response = $response;
        return $this;
    }
}