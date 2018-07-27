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
     * @param string $field
     * @param array $values
     */
    protected function setWhere($field, $values)
    {
        $values = (array)$values;
        if (!$values) return;
        if (count($values) > 1) {
            $this->where[] = $field.' IN (' . implode(', ', array_fill(0, count($values), '?')) . ')';
            foreach ($values as $value) {
                $this->param[] = $value;
            }
        } else {
            $this->where[] = $field.' = ?';
            $this->param[] = $values[0];
        }
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
     * @param string[]|string $deviceBots
     */
    public function deviceBots($deviceBots)
    {
        $this->setWhere('`device_bot`', $deviceBots);
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
     * @param string[]|string $bots
     */
    public function ipBot($bots)
    {
        $this->setWhere('`ip_bot`', $bots);
    }

    /**
     * @param string[]|string $offers
     */
    public function offers($offers)
    {
        $this->setWhere('`offer`', $offers);
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
     */
    public function token($token)
    {
        $this->tokens[$token] = $token;
    }

    /**
     * @return Statement
     */
    public function getStatement()
    {
        $join = [];
        if ($this->tokens) {
            foreach ($this->tokens as $token) {
                $this->select[] = '`tokens`.`value` AS `token_' . $token . '`';
                $where[] = '`tokens`.`token` = \''.$token.'\'';
            }
            $join[] = ' LEFT JOIN `tokens` ON `tokens`.`click_id` = `clicks`.`id`';
        }
        $sql = 'SELECT '.(implode(', ', $this->select)).' FROM `clicks`'.(implode($join));
        if ($this->where) $sql .= ' WHERE '.(implode(' AND ', $this->where));
        $sql .= ';';
        $statement = new Statement();
        $statement->query = $sql;
        $statement->parameters = $this->param;
        return $statement;
    }
}