<?php

namespace Cpa\Metrics;

use Cpa\Metrics\DTO\Click as ClickDTO;
use Cpa\Metrics\DTO\Clicks;
use Cpa\Metrics\Filter\Click as ClickFilter;
use Cpa\Metrics\DTO\Statistics as StatisticsDTO;
use Cpa\Metrics\Filter\Statistics as StatisticsFilter;
use PDO;
use PDOStatement;
use DateTime;

/**
 * Class Metrics
 */
class Metrics
{

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @var PDOStatement
     */
    protected $click;

    /**
     * @var PDOStatement
     */
    protected $lead;

    /**
     * @var PDOStatement
     */
    protected $token;

    /**
     * @var PDOStatement
     */
    protected $profit;

    /**
     * @var PDOStatement
     */
    protected $cost;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        $exists = file_exists($file);
        $this->db = new PDO('sqlite:'.$file);
        if (!$exists) {
            $this->createDatabase();
        }
    }

    /**
     * @param void
     * @return void
     */
    protected function createDatabase()
    {
        $sql = <<<SQL
CREATE TABLE `clicks` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `time` TIMESTAMP,
  `campaign` TEXT,
  `source` TEXT,
  `creative` TEXT,
  `keyword` TEXT,
  `rule_hash` TEXT,
  `rule` TEXT,
  `request` TEXT,
  `response` TEXT,
  `ip` TEXT,
  `offer_id` TEXT,
  `offer_category` TEXT,
  `offer_network` TEXT,
  `offer` TEXT,
  `device_type` TEXT,
  `device_vendor` TEXT,
  `device_model` TEXT,
  `os_name` TEXT,
  `os_version` TEXT,
  `browser_name` TEXT,
  `browser_version` TEXT,
  `browser_engine` TEXT,
  `geo_country` TEXT,
  `geo_area` TEXT,
  `geo_city` TEXT,
  `bot_detected` INTEGER,
  `bot_owner` TEXT,
  `bot_type` TEXT,
  `bot_name` TEXT,
  `lead` INTEGER,
  `status` TEXT,
  `cost_amount` TEXT,
  `cost_currency` TEXT,
  `profit_amount` TEXT,
  `profit_currency` TEXT
); 

CREATE TABLE `tokens` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `click_id` INTEGER,
  `token` TEXT,
  `value` TEXT,
  CONSTRAINT `fk_click` FOREIGN KEY (`click_id`) REFERENCES `clicks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
); 

CREATE TABLE `currencies` (
  `code` TEXT PRIMARY KEY ON CONFLICT IGNORE
);

CREATE INDEX `time` ON `clicks` (`time`);
CREATE INDEX `ip` ON `clicks` (`ip`);
CREATE INDEX `bot_detected` ON `clicks` (`bot_detected`);
CREATE INDEX `bot_owner` ON `clicks` (`bot_owner`);
CREATE INDEX `bot_type` ON `clicks` (`bot_type`);
CREATE INDEX `bot_name` ON `clicks` (`bot_name`);
CREATE INDEX `campaign` ON `clicks` (`campaign`);
CREATE INDEX `source` ON `clicks` (`source`);
CREATE INDEX `creative` ON `clicks` (`creative`);
CREATE INDEX `keyword` ON `clicks` (`keyword`);
CREATE INDEX `rule_hash` ON `clicks` (`rule_hash`);
CREATE INDEX `device_type` ON `clicks` (`device_type`);
CREATE INDEX `device_vendor` ON `clicks` (`device_vendor`);
CREATE INDEX `device_model` ON `clicks` (`device_model`);
CREATE INDEX `geo_country` ON `clicks` (`geo_country`);
CREATE INDEX `geo_area` ON `clicks` (`geo_area`);
CREATE INDEX `geo_city` ON `clicks` (`geo_city`);
CREATE INDEX `os_name` ON `clicks` (`os_name`);
CREATE INDEX `os_version` ON `clicks` (`os_version`);
CREATE INDEX `browser_name` ON `clicks` (`browser_name`);
CREATE INDEX `browser_version` ON `clicks` (`browser_version`);
CREATE INDEX `browser_engine` ON `clicks` (`browser_engine`);
CREATE INDEX `offer_id` ON `clicks` (`offer_id`);
CREATE INDEX `offer_category` ON `clicks` (`offer_category`);
CREATE INDEX `offer_network` ON `clicks` (`offer_network`);
CREATE INDEX `lead` ON `clicks` (`lead`);
CREATE INDEX `status` ON `clicks` (`status`);
CREATE INDEX `token_name` ON `tokens` (`token`);
CREATE INDEX `token_value` ON `tokens` (`value`);

CREATE TRIGGER auto_cost_currency_insert BEFORE INSERT
ON `clicks` WHEN NEW.cost_currency <> ''
BEGIN
INSERT INTO `currencies` (code) VALUES (NEW.cost_currency);
END;

CREATE TRIGGER auto_profit_currency_insert BEFORE INSERT
ON `clicks` WHEN NEW.profit_currency <> ''
BEGIN
INSERT INTO `currencies` (code) VALUES (NEW.profit_currency);
END;

CREATE TRIGGER auto_profit_currency_update BEFORE UPDATE
ON `clicks` WHEN NEW.profit_currency <> ''
BEGIN
INSERT INTO `currencies` (code) VALUES (NEW.profit_currency);
END;

CREATE TRIGGER auto_cost_currency_update BEFORE UPDATE
ON `clicks` WHEN NEW.cost_currency <> ''
BEGIN
INSERT INTO `currencies` (code) VALUES (NEW.cost_currency);
END;
SQL;
        $this->db->exec($sql);
    }

    /**
     * @param ClickDTO $click
     * @return bool
     */
    public function save(ClickDTO $click) {
        $this->db->beginTransaction();
        if (!$this->clickStatement()) return false;
        if (!$this->tokenStatement()) return false;
        $this->clickStatement()->execute([
            $click->time->format(DATE_W3C),
            $click->campaign,
            $click->source,
            $click->creative,
            $click->keyword,
            md5($click->rule),
            $click->rule,
            $click->request,
            $click->response,
            $click->ip,
            $click->offer->id,
            $click->offer->category,
            $click->offer->network,
            $click->device->type,
            $click->device->vendor,
            $click->device->model,
            $click->os->name,
            $click->os->version,
            $click->browser->name,
            $click->browser->version,
            $click->browser->engine,
            $click->geo->country,
            $click->geo->area,
            $click->geo->city,
            $click->bot->detected,
            $click->bot->owner,
            $click->bot->type,
            $click->bot->name,
            $click->lead->lead,
            $click->lead->status,
            $click->cost->amount,
            $click->cost->currency,
            $click->profit->amount,
            $click->profit->currency,
        ]);
        $clickId = $this->db->lastInsertId();
        if (!$clickId) {
            $this->db->rollBack();
            return false;
        }
        foreach ($click->tokens as $token => $value) {
            $res = $this->tokenStatement()->execute([$clickId, $token, $value]);
            if (!$res) {
                $this->db->rollBack();
                return false;
            }
        }
        $this->db->commit();
        return true;
    }

    /**
     * @param StatisticsFilter $filter
     * @return StatisticsDTO
     */
    public function statistics(StatisticsFilter $filter)
    {
        $result = new StatisticsDTO();
        $rows = array();
        $empty = array();
        $r = $this->db->query('SELECT `code` FROM `currencies`');
        while ($row  = $r->fetch(PDO::FETCH_ASSOC)) {
            $empty['cost_'.$row['code']] = 0;
            $empty['profit_'.$row['code']] = 0;
        }
        ksort($empty);
        $statement = $filter->getStatement();
        $r = $this->db->prepare($statement->query);
        $r->execute($statement->parameters);
        $row = null;
        while ($row  = $r->fetch(PDO::FETCH_ASSOC)) {
            $tmp = $row;
            unset($tmp['profit']);
            unset($tmp['profit_currency']);
            unset($tmp['cost']);
            unset($tmp['cost_currency']);
            unset($tmp['count']);
            unset($tmp['leads']);
            $key = implode('.', $tmp);

            if (!isset($rows[$key])) {
                $rows[$key] = $tmp;
                $rows[$key]['count'] = $row['count'];
                $rows[$key]['leads'] = $row['leads'];
                $rows[$key] = array_replace($rows[$key], $empty);
            } else {
                $rows[$key]['count'] += $row['count'];
                $rows[$key]['leads'] += $row['leads'];
                if ($row['cost'] > 0) $rows[$key]['cost_'.$row['cost_currency']] += $row['cost'];
                if ($row['profit'] > 0) $rows[$key]['profit_'.$row['profit_currency']] += $row['profit'];
            }
        }
        $result->rows = array_values($rows);
        if ($result->rows) $result->head = array_keys($result->rows[0]);
        return $result;
    }

    /**
     * @param ClickFilter $filter
     * @return Clicks
     */
    public function clicks(ClickFilter $filter)
    {
        $rows = array();
        $statement = $filter->getStatement();
        $r = $this->db->prepare($statement->query);
        $r->execute($statement->parameters);
        while ($row  = $r->fetch(PDO::FETCH_ASSOC)) {
            $click = new ClickDTO();
            $click->id = $row['id'];
            $click->time = new DateTime($row['time']);
            $click->campaign = (string)$row['campaign'];
            $click->source = (string)$row['source'];
            $click->creative = (string)$row['creative'];
            $click->keyword = (string)$row['keyword'];
            $click->response = (string)$row['response'];
            $click->request = (string)$row['request'];
            $click->rule = (string)$row['rule'];
            $click->ip = (string)$row['ip'];
            $click->offer->id = (string)$row['offer_id'];
            $click->offer->category = (string)$row['offer_category'];
            $click->offer->network = (string)$row['offer_network'];
            $click->device->type = (string)$row['device_type'];;
            $click->device->vendor = (string)$row['device_vendor'];
            $click->device->model = (string)$row['device_model'];
            $click->os->name = (string)$row['os_name'];
            $click->os->version = (string)$row['os_version'];
            $click->browser->name = (string)$row['browser_name'];
            $click->browser->version = (string)$row['browser_version'];
            $click->browser->engine = (string)$row['browser_engine'];
            $click->geo->country = (string)$row['geo_country'];
            $click->geo->area = (string)$row['geo_area'];
            $click->geo->city = (string)$row['geo_city'];
            $click->bot->detected = (bool)$row['bot_detected'];
            $click->bot->owner = (string)$row['bot_owner'];
            $click->bot->type = (string)$row['bot_type'];
            $click->bot->name = (string)$row['bot_name'];
            $click->lead->status = (string)$row['status'];
            $click->lead->lead = (bool)$row['lead'];
            $click->cost->amount = (double)$row['cost_amount'];
            $click->cost->currency = (string)$row['cost_currency'];
            $click->profit->amount = (double)$row['profit_amount'];
            $click->profit->currency = (string)$row['profit_currency'];
            $click->tokens = array();
            $rows[$row['id']] = $click;
        }
        $r = $this->db->query('SELECT * FROM `tokens` WHERE `click_id` IN ('.implode(', ', array_keys($rows)).')');
        while ($row  = $r->fetch(PDO::FETCH_ASSOC)) {
            $rows[$row['click_id']]->tokens[$row['token']] = $row['value'];
        }
        $statement = $filter->getCountStatement();
        $r = $this->db->prepare($statement->query);
        $r->execute($statement->parameters);
        $result = new Clicks();
        $result->count = $r->fetchColumn();
        $result->items = array_values($rows);
        return $result;
    }

    /**
     * @param int $clickId
     * @param bool $lead
     * @param string $status
     */
    public function lead($clickId, $lead, $status)
    {
        $this->leadStatement()->execute([
            $status,
            $lead,
            $clickId,
        ]);
    }

    /**
     * @param int $clickId
     * @param double $amount
     * @param string $currency
     */
    public function profit($clickId, $amount, $currency)
    {
        $this->profitStatement()->execute([
            $amount,
            $currency,
            $clickId,
        ]);
    }

    /**
     * @param int $clickId
     * @param double $amount
     * @param string $currency
     */
    public function cost($clickId, $amount, $currency)
    {
        $this->costStatement()->execute([
            $amount,
            $currency,
            $clickId,
        ]);
    }

    /**
     * @return bool|PDOStatement
     */
    protected function clickStatement()
    {
        if (!$this->click) {
$sql = <<<SQL
INSERT INTO `clicks` (
  `time`,
  `campaign`,
  `source`,
  `creative`,
  `keyword`,
  `rule_hash`,
  `rule`,
  `request`,
  `response`,
  `ip`,
  `offer_id`,
  `offer_category`,
  `offer_network`,
  `device_type`,
  `device_vendor`,
  `device_model`,
  `os_name`,
  `os_version`,
  `browser_name`,
  `browser_version`,
  `browser_engine`,
  `geo_country`,
  `geo_area`,
  `geo_city`,
  `bot_detected`,
  `bot_owner`,
  `bot_type`,
  `bot_name`,
  `lead`,
  `status`,
  `cost_amount`,
  `cost_currency`,
  `profit_amount`,
  `profit_currency`
) VALUES (
  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)
SQL;

            $this->click = $this->db->prepare($sql);
        }
        return $this->click;
    }

    /**
     * @return bool|PDOStatement
     */
    protected function tokenStatement()
    {
        if (!$this->token) {
            $this->token = $this->db->prepare(
                'INSERT INTO `tokens` (`click_id`, `token`, `value`) VALUES (?, ?, ?);'
            );
        }
        return $this->token;
    }

    /**
     * @return bool|PDOStatement
     */
    protected function leadStatement()
    {
        if (!$this->lead) {
            $this->lead = $this->db->prepare(
                'UPDATE `clicks` SET `status` = ?, `lead` = ? WHERE id = ?;'
            );
        }
        return $this->lead;
    }

    /**
     * @return bool|PDOStatement
     */
    protected function profitStatement()
    {
        if (!$this->profit) {
            $this->profit = $this->db->prepare(
                'UPDATE `clicks` SET `profit_amount` = ?, `profit_currency` = ? WHERE id = ?;'
            );
        }
        return $this->profit;
    }

    /**
     * @return bool|PDOStatement
     */
    protected function costStatement()
    {
        if (!$this->cost) {
            $this->cost = $this->db->prepare(
                'UPDATE `clicks` SET `cost_amount` = ?, `cost_currency` = ? WHERE id = ?;'
            );
        }
        return $this->cost;
    }
}