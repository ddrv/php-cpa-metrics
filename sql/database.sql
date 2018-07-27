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