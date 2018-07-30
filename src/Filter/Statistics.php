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
        'uniques' => 'SUM (`unique_visit`) AS `uniques`',
        'cost' => 'SUM (`cost_amount`) AS `cost`',
        'profit' => 'SUM (`profit_amount`) AS `profit`',
        'cost_currency' => '`cost_currency`',
        'profit_currency' => '`profit_currency`',
    );

    /**
     * @var array
     */
    protected $group = array(
        'cost_currency' => '`cost_currency`',
        'profit_currency' => '`profit_currency`',
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
        $this->group['year'] = '`group_year`';
        $this->select[] = 'strftime(\'%Y\', `clicks`.`time`) AS `group_year`';
    }

    /**
     * @param void
     */
    public function groupTimeMonth()
    {
        $this->group['month'] = '`group_month`';
        $this->select['month'] = 'strftime(\'%m\', `clicks`.`time`) AS `group_month`';
    }

    /**
     * @param void
     */
    public function groupTimeDay()
    {
        $this->group['day'] = '`group_day`';
        $this->select['day'] = 'strftime(\'%d\', `clicks`.`time`) AS `group_day`';
    }

    /**
     * @param void
     */
    public function groupTimeHour()
    {
        $this->group['hour'] = '`group_hour`';
        $this->select['hour'] = 'strftime(\'%H\', `clicks`.`time`) AS `group_hour`';
    }

    /**
     * @param void
     */
    public function groupTimeMinute()
    {
        $this->group['minute'] = '`group_minute`';
        $this->select['minute'] = 'strftime(\'%M\', `clicks`.`time`) AS `group_minute`';
    }

    /**
     * @param void
     */
    public function groupTimeWeekday()
    {
        $this->group['weekday'] = '`group_weekday`';
        $this->select['weekday'] = 'strftime(\'%w\', `clicks`.`time`) AS `group_weekday`';
    }

    /**
     * @param void
     */
    public function groupCampaign()
    {
        $this->group['campaign'] = '`group_campaign`';
        $this->select['campaign'] = '`campaign` AS `group_campaign`';
    }

    /**
     * @param void
     */
    public function groupTrafficSource()
    {
        $this->group['source'] = '`group_source`';
        $this->select['source'] = '`source` AS `group_source`';
    }

    /**
     * @param void
     */
    public function groupCreative()
    {
        $this->group['creative'] = '`group_creative`';
        $this->select['creative'] = '`creative` AS `group_creative`';
    }

    /**
     * @param void
     */
    public function groupKeyword()
    {
        $this->group['keyword'] = '`group_keyword`';
        $this->select['keyword'] = '`keyword` AS `group_keyword`';
    }

    /**
     * @param void
     */
    public function groupDeviceType()
    {
        $this->group['device_type'] = '`group_device_type`';
        $this->select['device_type'] = '`device_type` AS `group_device_type`';
    }

    /**
     * @param void
     */
    public function groupDeviceVendor()
    {
        $this->group['device_vendor'] = '`group_device_vendor`';
        $this->select['device_vendor'] = '`device_vendor` AS `group_device_vendor`';
    }

    /**
     * @param void
     */
    public function groupDeviceModel()
    {
        $this->group['device_model'] = '`group_device_model`';
        $this->select['device_model'] = '`device_model` AS `group_device_model`';
    }

    /**
     * @param void
     */
    public function groupBot()
    {
        $this->group['bot_detected'] = '`group_bot`';
        $this->select['bot_detected'] = '`bot_detected` AS `group_bot`';
    }

    /**
     * @param void
     */
    public function groupBotOwner()
    {
        $this->group['bot_owner'] = '`group_bot_owner`';
        $this->select['bot_owner'] = '`bot_owner` AS `group_bot_owner`';
    }

    /**
     * @param void
     */
    public function groupBotType()
    {
        $this->group['bot_type'] = '`group_bot_type`';
        $this->select['bot_type'] = '`bot_type` AS `group_bot_type`';
    }

    /**
     * @param void
     */
    public function groupBotName()
    {
        $this->group['bot_name'] = '`group_bot_name`';
        $this->select['bot_name'] = '`bot_name` AS `group_bot_name`';
    }

    /**
     * @param void
     */
    public function groupOsName()
    {
        $this->group['os_name'] = '`group_os_name`';
        $this->select['os_name'] = '`os_name` AS `group_os_name`';
    }

    /**
     * @param void
     */
    public function groupOsVersion()
    {
        $this->group['os_version'] = '`group_os_version`';
        $this->select['os_version'] = '`os_version` AS `group_os_version`';
    }

    /**
     * @param void
     */
    public function groupBrowserName()
    {
        $this->group['browser_name'] = '`group_browser_name`';
        $this->select['browser_name'] = '`browser_name` AS `group_browser_name`';
    }

    /**
     * @param void
     */
    public function groupBrowserVersion()
    {
        $this->group['browser_version'] = '`group_browser_version`';
        $this->select['browser_version'] = '`browser_version` AS `group_browser_version`';
    }

    /**
     * @param void
     */
    public function groupBrowserEngine()
    {
        $this->group['browser_engine'] = '`group_browser_engine`';
        $this->select['browser_engine'] = '`browser_engine` AS `group_browser_engine`';
    }

    /**
     * @param void
     */
    public function groupGeoCountry()
    {
        $this->group['geo_country'] = '`group_geo_country`';
        $this->select['geo_country'] = '`geo_country` AS `group_geo_country`';
    }

    /**
     * @param void
     */
    public function groupGeoArea()
    {
        $this->group['geo_area'] = '`group_geo_area`';
        $this->select['geo_area'] = '`geo_area` AS `group_geo_area`';
    }

    /**
     * @param void
     */
    public function groupGeoCity()
    {
        $this->group['geo_city'] = '`group_geo_city`';
        $this->select['geo_city'] = '`geo_city` AS `group_geo_city`';
    }

    /**
     * @param void
     */
    public function groupRule()
    {
        $this->group['rule_hash'] = '`rule_hash`';
        $this->select['rule_hash'] = '`rule` AS `group_rule`';
    }

    /**
     * @param void
     */
    public function groupOffer()
    {
        $this->group['offer_id'] = '`group_offer_id`';
        $this->select['offer_id'] = '`offer_id` AS `group_offer_id`';
    }

    /**
     * @param void
     */
    public function groupOfferNetwork()
    {
        $this->group['offer_network'] = '`group_offer_network`';
        $this->select['offer_network'] = '`offer_network` AS `group_offer_network`';
    }

    /**
     * @param void
     */
    public function groupOfferCategory()
    {
        $this->group['offer_category'] = '`group_offer_category`';
        $this->select['offer_category'] = '`offer_category` AS `group_offer_category`';
    }

    /**
     * @param void
     */
    public function groupStatus()
    {
        $this->group['status'] = '`group_status`';
        $this->select['status'] = '`status` AS `group_status`';
    }

    /**
     * @param void
     */
    public function groupUnique()
    {
        $this->group['unique'] = '`group_unique`';
        $this->select['status'] = '`unique_visit` AS `group_unique`';
    }

    /**
     * @param string $token
     */
    public function groupToken($token)
    {
        $this->tokens[$token] = $token;
        $this->group['token_'.$token] = '`token_'.$token.'`';
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
                $this->select[] = '`tokens_'.$token.'`.`value` AS `token_' . $token . '`';
                $params[] = $token;
                $join[] = ' LEFT JOIN `tokens` AS `tokens_'.$token.'` ON (`tokens_'.$token.'`.`click_id` = `clicks`.`id` AND `tokens_'.$token.'`.`token` = ?)';
            }
        }
        $sql = 'SELECT '.(implode(', ', $this->select)).' FROM `clicks`'.(implode($join));
        if ($this->from && $this->from instanceof DateTime) {
            $where[] = '`clicks`.`time` >= ?';
            $params[] = $this->from->format(DATE_W3C);
        }
        if ($this->to && $this->to instanceof DateTime) {
            $where[] = '`clicks`.`time` <= ?';
            $params[] = $this->to->format(DATE_W3C);
        }
        if ($where) $sql .= ' WHERE '.(implode(' AND ', $where));
        if ($group) $sql .= ' GROUP BY '.(implode(', ',$group));

        $sql .= ';';
        $statement = new Statement();
        $statement->query = $sql;
        $statement->parameters = $params;
        return $statement;
    }
}