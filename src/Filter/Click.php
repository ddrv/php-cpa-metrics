<?php

namespace Cpa\Metrics\Filter;

use Cpa\Metrics\DTO\Statement;
use DateTime;

/**
 * Class Statistics
 */
class Click
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
        '*',
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
     * @var array
     */
    protected $where = array();

    /**
     * @var array
     */
    protected $param = array();

    /**
     * @var array
     */
    protected $join = array();

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @var int
     */
    protected $count = 100;

    /**
     * @param void
     */
    public function __construct()
    {
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
     * @param int $offset
     */
    public function offset($offset)
    {
        $this->offset = (int)$offset;
    }

    /**
     * @param int $count
     */
    public function count($count)
    {
        $count = (int)$count;
        if ($count < 1) $count = 1;
        if ($count > 100) $count = 100;
        $this->count = $count;
    }

    /**
     * @param int[]|int $years
     */
    public function timeYears($years)
    {
        $this->setWhere('strftime(\'%Y\', `clicks`.`time`)', $years);
    }

    /**
     * @param int[]|int $months
     */
    public function timeMonths($months)
    {
        $months = (array)$months;
        $mnths = array();
        foreach ($months as $month) {
            $mnth = (int)$month;
            if ($mnth < 1 && $mnth > 12) continue;
            if ($mnth < 10) $mnth = '0'.$mnth;
            $mnths[] = $mnth;
        }
        $this->setWhere('strftime(\'%m\', `clicks`.`time`)', $mnths);
    }

    /**
     * @param int[]|int $days
     */
    public function timeDays($days)
    {
        $days = (array)$days;
        $ds = array();
        foreach ($days as $day) {
            $d = (int)$day;
            if ($d < 1 && $d > 31) continue;
            if ($d < 10) $d = '0'.$d;
            $ds[] = $d;
        }
        $this->setWhere('strftime(\'%d\', `clicks`.`time`)', $ds);
    }

    /**
     * @param int[]|int $hours
     */
    public function timeHours($hours)
    {
        $hours = (array)$hours;
        $hs = array();
        foreach ($hours as $hour) {
            $h = (int)$hour;
            if ($h < 0 && $h > 23) continue;
            if ($h < 10) $h = '0'.$h;
            $hs[] = $h;
        }
        $this->setWhere('strftime(\'%H\', `clicks`.`time`)', $hs);
    }

    /**
     * @param int[]|int $minutes
     */
    public function timeMinutes($minutes)
    {
        $minutes = (array)$minutes;
        $ms = array();
        foreach ($minutes as $minute) {
            $m = (int)$minute;
            if ($m < 0 && $m > 59) continue;
            if ($m < 10) $m = '0'.$m;
            $ms[] = $m;
        }
        $this->setWhere('strftime(\'%M\', `clicks`.`time`)', $ms);
    }

    /**
     * @param int[]|int $weekdays
     */
    public function timeWeekdays($weekdays)
    {
        $weekdays = (array)$weekdays;
        $wds = array();
        foreach ($weekdays as $weekday) {
            $wd = (int)$weekday;
            if ($wd < 1 && $wd > 7) continue;
            $wds[] = $wd;
        }
        $this->setWhere('strftime(\'%w\', `clicks`.`time`)', $wds);
    }

    /**
     * @param string[]|string $campaigns
     */
    public function campaigns($campaigns)
    {
        $this->campaigns = (array)$campaigns;
    }

    /**
     * @param string[]|string $sources
     */
    public function sources($sources)
    {
        $this->setWhere('`source`', $sources);
    }

    /**
     * @param string[]|string $creatives
     */
    public function creatives($creatives)
    {
        $this->setWhere('`creative`', $creatives);
    }

    /**
     * @param string[]|string $keywords
     */
    public function keywords($keywords)
    {
        $this->setWhere('`keyword`', $keywords);
    }

    /**
     * @param string[]|string $deviceTypes
     */
    public function deviceTypes($deviceTypes)
    {
        $this->setWhere('`device_type`', $deviceTypes);
    }

    /**
     * @param string[]|string $deviceVendors
     */
    public function deviceVendors($deviceVendors)
    {
        $this->setWhere('`device_vendor`', $deviceVendors);
    }

    /**
     * @param string[]|string $deviceModels
     */
    public function deviceModels($deviceModels)
    {
        $this->setWhere('`device_model`', $deviceModels);
    }

    /**
     * @param string[]|string $osNames
     */
    public function osNames($osNames)
    {
        $this->setWhere('`os_name`', $osNames);
    }

    /**
     * @param string[]|string $osVersions
     */
    public function osVersions($osVersions)
    {
        $this->setWhere('`os_version`', $osVersions);
    }

    /**
     * @param string[]|string $browserNames
     */
    public function browserNames($browserNames)
    {
        $this->setWhere('`browser_name`', $browserNames);
    }

    /**
     * @param string[]|string $browserVersions
     */
    public function browseVersions($browserVersions)
    {
        $this->setWhere('`browser_version`', $browserVersions);
    }

    /**
     * @param string[]|string $browserEngines
     */
    public function browseEngines($browserEngines)
    {
        $this->setWhere('`browser_engine`', $browserEngines);
    }

    /**
     * @param string[]|string $countries
     */
    public function geoCountries($countries)
    {
        $this->setWhere('`geo_country`', $countries);
    }

    /**
     * @param string[]|string $areas
     */
    public function geoAreas($areas)
    {
        $this->setWhere('`geo_area`', $areas);
    }

    /**
     * @param string[]|string $cities
     */
    public function geoCities($cities)
    {
        $this->setWhere('`geo_city`', $cities);
    }

    /**
     * @param bool[]|bool $bots
     */
    public function bots($bots)
    {
        $this->setWhere('`bot_detected`', $bots);
    }

    /**
     * @param string[]|string $botOwners
     */
    public function botOwners($botOwners)
    {
        $this->setWhere('`bot_owner`', $botOwners);
    }

    /**
     * @param string[]|string $botTypes
     */
    public function botTypes($botTypes)
    {
        $this->setWhere('`bot_type`', $botTypes);
    }

    /**
     * @param string[]|string $botNames
     */
    public function botNames($botNames)
    {
        $this->setWhere('`bot_name`', $botNames);
    }

    /**
     * @param string[]|string $offers
     */
    public function offers($offers)
    {
        $this->setWhere('`offer_id`', $offers);
    }

    /**
     * @param string[]|string $networks
     */
    public function offerNetworks($networks)
    {
        $this->setWhere('`offer_network`', $networks);
    }

    /**
     * @param string[]|string $categories
     */
    public function offerCategories($categories)
    {
        $this->setWhere('`offer_category`', $categories);
    }

    /**
     * @param string[]|string $statuses
     */
    public function statuses($statuses)
    {
        $this->setWhere('`status`', $statuses);
    }

    /**
     * @param string $token
     * @param string[]|string $values
     */
    public function token($token, $values)
    {
        $values = (array)$values;
        if (!$values) return;
        $this->select[] = '`tokens`.`value` AS `token_' . $token . '`';
        $p = 'p'.count($this->param);
        $this->param[$p] = $token;
        if (count($values) > 1) {
            $in = array();
            foreach ($values as $value) {
                $pv = 'p'.count($this->param);
                $in[] = ':'.$pv;
                $this->param[$pv] = $value;
            }
            $where = ' IN (' . implode(', ', $in) . ')';
        } else {
            $pv = 'p'.count($this->param);
            $where = ' = :'.$pv;
            $this->param[$pv] = $values[0];
        }
        $this->join[] = ' INNER JOIN `tokens` ON (`tokens`.`click_id` = `clicks`.`id` AND `tokens`.`token` = :'.$p.' AND `tokens`.`value`'.$where.')';
    }

    /**
     * @return Statement
     */
    public function getStatement()
    {
        $sql = 'SELECT '.(implode(', ', $this->select)).' FROM `clicks`'.(implode($this->join));
        if ($this->where) $sql .= ' WHERE '.(implode(' AND ', $this->where));
        $sql .= ' LIMIT '.$this->count.' OFFSET '.$this->offset;
        $sql .= ';';
        $statement = new Statement();
        $statement->query = $sql;
        $statement->parameters = $this->param;
        return $statement;
    }

    /**
     * @return Statement
     */
    public function getCountStatement()
    {
        $sql = 'SELECT COUNT(*) AS `count` FROM `clicks`'.(implode($this->join));
        if ($this->where) $sql .= ' WHERE '.(implode(' AND ', $this->where));
        $sql .= ';';
        $statement = new Statement();
        $statement->query = $sql;
        $statement->parameters = $this->param;
        return $statement;
    }

    /**
     * @param string $field
     * @param array $values
     */
    protected function setWhere($field, $values)
    {
        $values = (array)$values;
        if (!$values) return;
        if (count($values) > 1) {
            $in = array();
            foreach ($values as $value) {
                $pv = 'p'.count($this->param);
                $in[] = ':'.$pv;
                $this->param[$pv] = $value;
            }
            $this->where[] = $field.' IN (' . implode(', ', $in) . ')';
        } else {
            $pv = 'p'.count($this->param);
            $this->where[] = $field.' = :'.$pv;
            $this->param[$pv] = $values[0];
        }
    }
}