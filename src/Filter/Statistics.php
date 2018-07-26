<?php

namespace Cpa\Metrics\Filter;

use Cpa\Metrics\DTO\Statement;
use DateTime;

/**
 * Class Statistics
 */
class Statistics
{

    /**
     * @var DateTime
     */
    protected $from;

    /**
     * @var DateTime
     */
    protected $to;

    /**
     * @var array
     */
    protected $select = array(
        'count' => 'COUNT (*) AS `count`',
        'leads' => 'SUM (`lead`) AS `leads`',
        'cost' => 'SUM (`cost_amount`) AS `cost`',
        'profit' => 'SUM (`profit_amount`) AS `profit`',
        'cost_currency' => '`cost_currency`',
        'profit_currency' => '`profit_currency`',
    );

    /**
     * @var array
     */
    protected $group = array(
        'cost_currency' => 'cost_currency',
        'profit_currency' => 'profit_currency',
    );

    /**
     * @var array
     */
    protected $campaigns = array();

    /**
     * @var array
     */
    protected $tokens = array();

    /**
     * @param void
     */
    public function __construct()
    {
    }

    /**
     * @param array|string $campaigns
     */
    public function campaigns($campaigns)
    {
        $this->campaigns = array_values((array)$campaigns);
    }

    /**
     * @param DateTime $time
     */
    public function from($time)
    {
        $this->from = $time;
    }

    /**
     * @param DateTime $time
     */
    public function to($time)
    {
        $this->to = $time;
    }

    /**
     * @param void
     */
    public function groupTimeYear()
    {
        $this->group['year'] = 'year';
        $this->select[] = 'strftime(\'%Y\', `clicks`.`time`) AS `year`';
    }

    /**
     * @param void
     */
    public function groupTimeMonth()
    {
        $this->group['month'] = 'month';
        $this->select['month'] = 'strftime(\'%m\', `clicks`.`time`) AS `month`';
    }

    /**
     * @param void
     */
    public function groupTimeDay()
    {
        $this->group['day'] = 'day';
        $this->select['day'] = 'strftime(\'%d\', `clicks`.`time`) AS `day`';
    }

    /**
     * @param void
     */
    public function groupTimeHour()
    {
        $this->group['hour'] = 'hour';
        $this->select['hour'] = 'strftime(\'%H\', `clicks`.`time`) AS `hour`';
    }

    /**
     * @param void
     */
    public function groupTimeMinute()
    {
        $this->group['minute'] = 'minute';
        $this->select['minute'] = 'strftime(\'%M\', `clicks`.`time`) AS `minute`';
    }

    /**
     * @param void
     */
    public function groupTimeWeekday()
    {
        $this->group['weekday'] = 'weekday';
        $this->select['weekday'] = 'strftime(\'%w\', `clicks`.`time`) AS `weekday`';
    }

    /**
     * @param void
     */
    public function groupCampaign()
    {
        $this->group['campaign'] = 'campaign';
        $this->select['campaign'] = '`campaign`';
    }

    /**
     * @param void
     */
    public function groupTrafficSource()
    {
        $this->group['traffic_source'] = 'traffic_source';
        $this->select['traffic_source'] = '`traffic_source`';
    }

    /**
     * @param void
     */
    public function groupCreative()
    {
        $this->group['creative'] = 'creative';
        $this->select['creative'] = '`creative`';
    }

    /**
     * @param void
     */
    public function groupKeyword()
    {
        $this->group['keyword'] = 'keyword';
        $this->select['keyword'] = '`keyword`';
    }

    /**
     * @param void
     */
    public function groupDeviceType()
    {
        $this->group['device_type'] = 'device_type';
        $this->select['device_type'] = '`device_type`';
    }

    /**
     * @param void
     */
    public function groupDeviceVendor()
    {
        $this->group['device_vendor'] = 'device_vendor';
        $this->select['device_vendor'] = '`device_vendor`';
    }

    /**
     * @param void
     */
    public function groupDeviceModel()
    {
        $this->group['device_model'] = 'device_model';
        $this->select['device_model'] = '`device_model`';
    }

    /**
     * @param void
     */
    public function groupDeviceBot()
    {
        $this->group['device_bot'] = 'device_bot';
        $this->select['device_bot'] = '`device_bot`';
    }

    /**
     * @param void
     */
    public function groupOsName()
    {
        $this->group['os_name'] = 'os_name';
        $this->select['os_name'] = '`os_name`';
    }

    /**
     * @param void
     */
    public function groupOsVersion()
    {
        $this->group['os_version'] = 'os_version';
        $this->select['os_version'] = '`os_version`';
    }

    /**
     * @param void
     */
    public function groupBrowserName()
    {
        $this->group['browser_name'] = 'browser_name';
        $this->select['browser_name'] = '`browser_name`';
    }

    /**
     * @param void
     */
    public function groupBrowserVersion()
    {
        $this->group['browser_version'] = 'browser_version';
        $this->select['browser_version'] = '`browser_version`';
    }

    /**
     * @param void
     */
    public function groupBrowserEngine()
    {
        $this->group['browser_engine'] = 'browser_engine';
        $this->select['browser_engine'] = '`browser_engine`';
    }

    /**
     * @param void
     */
    public function groupGeoCountry()
    {
        $this->group['geo_country'] = 'geo_country';
        $this->select['geo_country'] = '`geo_country`';
    }

    /**
     * @param void
     */
    public function groupGeoArea()
    {
        $this->group['geo_area'] = 'geo_area';
        $this->select['geo_area'] = '`geo_area`';
    }

    /**
     * @param void
     */
    public function groupGeoCity()
    {
        $this->group['geo_city'] = 'geo_city';
        $this->select['geo_city'] = '`geo_city`';
    }

    /**
     * @param void
     */
    public function groupRule()
    {
        $this->group['rule_hash'] = 'rule_hash';
        $this->select['rule_hash'] = '`rule_hash`';
    }

    /**
     * @param void
     */
    public function groupIpBot()
    {
        $this->group['ip_bot'] = 'ip_bot';
        $this->select['ip_bot'] = '`ip_bot`';
    }

    /**
     * @param void
     */

    public function groupOffer()
    {
        $this->group['offer'] = 'offer';
        $this->select['offer'] = '`offer`';
    }

    /**
     * @param void
     */
    public function groupStatus()
    {
        $this->group['status'] = 'status';
        $this->select['status'] = '`status`';
    }

    /**
     * @param string $token
     */
    public function token($token)
    {
        $this->tokens[$token] = $token;
    }

    /**
     * @param string $token
     */
    public function groupToken($token)
    {
        $this->tokens[$token] = $token;
        $this->group['token_'.$token] = 'token_'.$token;
    }

    /**
     * @return Statement
     */
    public function getStatement()
    {
        $join = array();
        $where = array();
        $params = array();
        $group = $this->group;
        if (count($this->campaigns) > 1) {
            foreach ($this->campaigns as $campaign) {
                $params[] = $campaign;
            }
            $where[] = '`campaign` IN ('.implode(', ', array_fill(0, count($this->campaigns), '?')).')';

        } elseif (count($this->campaigns) == 1) {
            $where[] = '`campaign` = ?';
            $params[] = $this->campaigns[0];
        }
        if ($this->tokens) {
            foreach ($this->tokens as $token) {
                $this->select[] = '`tokens`.`value` AS `token_' . $token . '`';
                $where[] = '`tokens`.`token` = ?';
                $params[] = $token;
            }
            $join[] = ' LEFT JOIN `tokens` ON `tokens`.`click_id` = `clicks`.`id`';
        }
        $sql = 'SELECT '.(implode(', ', $this->select)).' FROM `clicks`'.(implode($join));
        if ($where) $sql .= ' WHERE '.(implode(' AND ', $where));
        if ($group) $sql .= ' GROUP BY '.(implode(', ',$group));

        $sql .= ';';
        $statement = new Statement();
        $statement->query = $sql;
        $statement->parameters = $params;
        return $statement;
    }
}