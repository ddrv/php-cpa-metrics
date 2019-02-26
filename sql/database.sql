CREATE TABLE clicks (
  click_id INTEGER NOT NULL CONSTRAINT pk PRIMARY KEY AUTOINCREMENT,
  click_time TIMESTAMP,
  click_lead BOOLEAN,
  click_status TEXT,
  click_nominal_cost REAL,
  click_nominal_profit REAL,
  traffic_campaign TEXT,
  traffic_source TEXT,
  traffic_creative TEXT,
  traffic_keyword TEXT,
  traffic_unique BOOLEAN,
  traffic_ip TEXT,
  traffic_rule_hash TEXT,
  traffic_rule TEXT,
  traffic_request_raw TEXT,
  traffic_response_raw TEXT,
  offer_id TEXT,
  offer_category TEXT,
  offer_network TEXT,
  device_type TEXT,
  device_vendor TEXT,
  device_model TEXT,
  os_name TEXT,
  os_version TEXT,
  browser_name TEXT,
  browser_version TEXT,
  browser_engine TEXT,
  geo_country TEXT,
  geo_area TEXT,
  geo_city TEXT,
  bot_detected BOOLEAN,
  bot_owner TEXT,
  bot_type TEXT,
  bot_name TEXT
);

CREATE TABLE tokens (
  token_id INTEGER NOT NULL CONSTRAINT pk PRIMARY KEY AUTOINCREMENT,
  click_id INTEGER NOT NULL,
  token TEXT,
  value TEXT,
  CONSTRAINT fk_click FOREIGN KEY (click_id) REFERENCES clicks (click_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE payments (
  payment_id TEXT NOT NULL,
  click_id INTEGER NOT NULL,
  payment_time TIMESTAMP,
  currency TEXT NOT NULL,
  amount REAL NOT NULL,
  is_profit BOOLEAN,
  CONSTRAINT pk PRIMARY KEY (payment_id, click_id),
  CONSTRAINT fk_click FOREIGN KEY (click_id) REFERENCES clicks (click_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE INDEX click_time ON clicks (click_time);
CREATE INDEX click_lead ON clicks (click_lead);
CREATE INDEX click_status ON clicks (click_status);
CREATE INDEX click_nominal_cost ON clicks (click_nominal_cost);
CREATE INDEX click_nominal_profit ON clicks (click_nominal_profit);
CREATE INDEX bot_detected ON clicks (bot_detected);
CREATE INDEX bot_owner ON clicks (bot_owner);
CREATE INDEX bot_type ON clicks (bot_type);
CREATE INDEX bot_name ON clicks (bot_name);
CREATE INDEX traffic_campaign ON clicks (traffic_campaign);
CREATE INDEX traffic_source ON clicks (traffic_source);
CREATE INDEX traffic_creative ON clicks (traffic_creative);
CREATE INDEX traffic_keyword ON clicks (traffic_keyword);
CREATE INDEX traffic_unique ON clicks (traffic_unique);
CREATE INDEX traffic_ip ON clicks (traffic_ip);
CREATE INDEX traffic_rule_hash ON clicks (traffic_rule_hash);
CREATE INDEX device_type ON clicks (device_type);
CREATE INDEX device_vendor ON clicks (device_vendor);
CREATE INDEX device_model ON clicks (device_model);
CREATE INDEX geo_country ON clicks (geo_country);
CREATE INDEX geo_area ON clicks (geo_area);
CREATE INDEX geo_city ON clicks (geo_city);
CREATE INDEX os_name ON clicks (os_name);
CREATE INDEX os_version ON clicks (os_version);
CREATE INDEX browser_name ON clicks (browser_name);
CREATE INDEX browser_version ON clicks (browser_version);
CREATE INDEX browser_engine ON clicks (browser_engine);
CREATE INDEX offer_id ON clicks (offer_id);
CREATE INDEX offer_category ON clicks (offer_category);
CREATE INDEX offer_network ON clicks (offer_network);
CREATE INDEX payments_time ON payments (payment_time);
CREATE INDEX payments_is_profit ON payments (is_profit) ;
CREATE INDEX token_token ON tokens (token);
CREATE INDEX token_value ON tokens (value);