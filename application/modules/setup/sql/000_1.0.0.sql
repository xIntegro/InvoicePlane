CREATE TABLE `xc_client_custom` (
  `client_custom_id` INT(11) NOT NULL AUTO_INCREMENT,
  `client_id`        INT(11) NOT NULL,
  PRIMARY KEY (`client_custom_id`),
  KEY `client_id` (`client_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_client_notes` (
  `client_note_id`   INT(11)  NOT NULL AUTO_INCREMENT,
  `client_id`        INT(11)  NOT NULL,
  `client_note_date` DATE     NOT NULL,
  `client_note`      LONGTEXT NOT NULL,
  PRIMARY KEY (`client_note_id`),
  KEY `client_id` (`client_id`, `client_note_date`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_clients` (
  `client_id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `client_date_created`  DATETIME     NOT NULL,
  `client_date_modified` DATETIME     NOT NULL,
  `client_name`          VARCHAR(100) NOT NULL,
  `client_address_1`     VARCHAR(100)          DEFAULT '',
  `client_address_2`     VARCHAR(100)          DEFAULT '',
  `client_city`          VARCHAR(45)           DEFAULT '',
  `client_state`         VARCHAR(35)           DEFAULT '',
  `client_zip`           VARCHAR(15)           DEFAULT '',
  `client_country`       VARCHAR(35)           DEFAULT '',
  `client_phone`         VARCHAR(20)           DEFAULT '',
  `client_fax`           VARCHAR(20)           DEFAULT '',
  `client_mobile`        VARCHAR(20)           DEFAULT '',
  `client_email`         VARCHAR(100)          DEFAULT '',
  `client_web`           VARCHAR(100)          DEFAULT '',
  `client_active`        INT(1)       NOT NULL DEFAULT '1',
  PRIMARY KEY (`client_id`),
  KEY `client_active` (`client_active`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_custom_fields` (
  `custom_field_id`     INT(11)     NOT NULL AUTO_INCREMENT,
  `custom_field_table`  VARCHAR(35) NOT NULL,
  `custom_field_label`  VARCHAR(64) NOT NULL,
  `custom_field_column` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`custom_field_id`),
  KEY `custom_field_table` (`custom_field_table`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_email_templates` (
  `email_template_id`    INT(11)      NOT NULL AUTO_INCREMENT,
  `email_template_title` VARCHAR(255) NOT NULL,
  `email_template_body`  LONGTEXT     NOT NULL,
  PRIMARY KEY (`email_template_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_import_details` (
  `import_detail_id`  INT(11)     NOT NULL AUTO_INCREMENT,
  `import_id`         INT(11)     NOT NULL,
  `import_lang_key`   VARCHAR(35) NOT NULL,
  `import_table_name` VARCHAR(35) NOT NULL,
  `import_record_id`  INT(11)     NOT NULL,
  PRIMARY KEY (`import_detail_id`),
  KEY `import_id` (`import_id`, `import_record_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_imports` (
  `import_id`   INT(11)  NOT NULL AUTO_INCREMENT,
  `import_date` DATETIME NOT NULL,
  PRIMARY KEY (`import_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_amounts` (
  `invoice_amount_id`      INT(11) NOT NULL AUTO_INCREMENT,
  `invoice_id`             INT(11) NOT NULL,
  `invoice_item_subtotal`  DECIMAL(10, 2)   DEFAULT '0.00',
  `invoice_item_tax_total` DECIMAL(10, 2)   DEFAULT '0.00',
  `invoice_tax_total`      DECIMAL(10, 2)   DEFAULT '0.00',
  `invoice_total`          DECIMAL(10, 2)   DEFAULT '0.00',
  `invoice_paid`           DECIMAL(10, 2)   DEFAULT '0.00',
  `invoice_balance`        DECIMAL(10, 2)   DEFAULT '0.00',
  PRIMARY KEY (`invoice_amount_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `invoice_paid` (`invoice_paid`, `invoice_balance`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_custom` (
  `invoice_custom_id` INT(11) NOT NULL AUTO_INCREMENT,
  `invoice_id`        INT(11) NOT NULL,
  PRIMARY KEY (`invoice_custom_id`),
  KEY `invoice_id` (`invoice_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_groups` (
  `invoice_group_id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `invoice_group_name`         VARCHAR(50) NOT NULL DEFAULT '',
  `invoice_group_prefix`       VARCHAR(10) NOT NULL DEFAULT '',
  `invoice_group_next_id`      INT(11)     NOT NULL,
  `invoice_group_left_pad`     INT(2)      NOT NULL DEFAULT '0',
  `invoice_group_prefix_year`  INT(1)      NOT NULL DEFAULT '0',
  `invoice_group_prefix_month` INT(1)      NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_group_id`),
  KEY `invoice_group_next_id` (`invoice_group_next_id`),
  KEY `invoice_group_left_pad` (`invoice_group_left_pad`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_item_amounts` (
  `item_amount_id` INT(11)        NOT NULL AUTO_INCREMENT,
  `item_id`        INT(11)        NOT NULL,
  `item_subtotal`  DECIMAL(10, 2) NOT NULL,
  `item_tax_total` DECIMAL(10, 2) NOT NULL,
  `item_total`     DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`item_amount_id`),
  KEY `item_id` (`item_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_items` (
  `item_id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `invoice_id`       INT(11)        NOT NULL,
  `item_tax_rate_id` INT(11)        NOT NULL DEFAULT '0',
  `item_date_added`  DATE           NOT NULL,
  `item_name`        VARCHAR(100)   NOT NULL,
  `item_description` LONGTEXT       NOT NULL,
  `item_quantity`    DECIMAL(10, 2) NOT NULL,
  `item_price`       DECIMAL(10, 2) NOT NULL,
  `item_order`       INT(2)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `invoice_id` (`invoice_id`, `item_tax_rate_id`, `item_date_added`, `item_order`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoice_tax_rates` (
  `invoice_tax_rate_id`     INT(11)        NOT NULL AUTO_INCREMENT,
  `invoice_id`              INT(11)        NOT NULL,
  `tax_rate_id`             INT(11)        NOT NULL,
  `include_item_tax`        INT(1)         NOT NULL DEFAULT '0',
  `invoice_tax_rate_amount` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`invoice_tax_rate_id`),
  KEY `invoice_id` (`invoice_id`, `tax_rate_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoices` (
  `invoice_id`            INT(11)     NOT NULL AUTO_INCREMENT,
  `user_id`               INT(11)     NOT NULL,
  `client_id`             INT(11)     NOT NULL,
  `invoice_group_id`      INT(11)     NOT NULL,
  `invoice_status_id`     TINYINT(2)  NOT NULL DEFAULT '1',
  `invoice_date_created`  DATE        NOT NULL,
  `invoice_date_modified` DATETIME    NOT NULL,
  `invoice_date_due`      DATE        NOT NULL,
  `invoice_number`        VARCHAR(20) NOT NULL,
  `invoice_terms`         LONGTEXT    NOT NULL,
  `invoice_url_key`       CHAR(32)    NOT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_url_key` (`invoice_url_key`),
  KEY `user_id` (`user_id`, `client_id`, `invoice_group_id`, `invoice_date_created`, `invoice_date_due`, `invoice_number`),
  KEY `invoice_status_id` (`invoice_status_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_invoices_recurring` (
  `invoice_recurring_id` INT(11) NOT NULL AUTO_INCREMENT,
  `invoice_id`           INT(11) NOT NULL,
  `recur_start_date`     DATE    NOT NULL,
  `recur_end_date`       DATE    NOT NULL,
  `recur_frequency`      CHAR(2) NOT NULL,
  `recur_next_date`      DATE    NOT NULL,
  PRIMARY KEY (`invoice_recurring_id`),
  KEY `invoice_id` (`invoice_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_item_lookups` (
  `item_lookup_id`   INT(11)        NOT NULL AUTO_INCREMENT,
  `item_name`        VARCHAR(100)   NOT NULL DEFAULT '',
  `item_description` LONGTEXT       NOT NULL,
  `item_price`       DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`item_lookup_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_merchant_responses` (
  `merchant_response_id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `invoice_id`                  INT(11)      NOT NULL,
  `merchant_response_date`      DATE         NOT NULL,
  `merchant_response_driver`    VARCHAR(35)  NOT NULL,
  `merchant_response`           VARCHAR(255) NOT NULL,
  `merchant_response_reference` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`merchant_response_id`),
  KEY `merchant_response_date` (`merchant_response_date`),
  KEY `invoice_id` (`invoice_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_payment_custom` (
  `payment_custom_id` INT(11) NOT NULL AUTO_INCREMENT,
  `payment_id`        INT(11) NOT NULL,
  PRIMARY KEY (`payment_custom_id`),
  KEY `payment_id` (`payment_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_payment_methods` (
  `payment_method_id`   INT(11)     NOT NULL AUTO_INCREMENT,
  `payment_method_name` VARCHAR(35) NOT NULL,
  PRIMARY KEY (`payment_method_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_payments` (
  `payment_id`        INT(11)        NOT NULL AUTO_INCREMENT,
  `invoice_id`        INT(11)        NOT NULL,
  `payment_method_id` INT(11)        NOT NULL DEFAULT '0',
  `payment_date`      DATE           NOT NULL,
  `payment_amount`    DECIMAL(10, 2) NOT NULL,
  `payment_note`      LONGTEXT       NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `payment_amount` (`payment_amount`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quote_amounts` (
  `quote_amount_id`      INT(11)        NOT NULL AUTO_INCREMENT,
  `quote_id`             INT(11)        NOT NULL,
  `quote_item_subtotal`  DECIMAL(10, 2) NOT NULL DEFAULT '0.00',
  `quote_item_tax_total` DECIMAL(10, 2) NOT NULL DEFAULT '0.00',
  `quote_tax_total`      DECIMAL(10, 2) NOT NULL DEFAULT '0.00',
  `quote_total`          DECIMAL(10, 2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`quote_amount_id`),
  KEY `quote_id` (`quote_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quote_custom` (
  `quote_custom_id` INT(11) NOT NULL AUTO_INCREMENT,
  `quote_id`        INT(11) NOT NULL,
  PRIMARY KEY (`quote_custom_id`),
  KEY `quote_id` (`quote_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quote_item_amounts` (
  `item_amount_id` INT(11)        NOT NULL AUTO_INCREMENT,
  `item_id`        INT(11)        NOT NULL,
  `item_subtotal`  DECIMAL(10, 2) NOT NULL DEFAULT '0.00',
  `item_tax_total` DECIMAL(10, 2) NOT NULL,
  `item_total`     DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`item_amount_id`),
  KEY `item_id` (`item_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quote_items` (
  `item_id`          INT(11)        NOT NULL AUTO_INCREMENT,
  `quote_id`         INT(11)        NOT NULL,
  `item_tax_rate_id` INT(11)        NOT NULL,
  `item_date_added`  DATE           NOT NULL,
  `item_name`        VARCHAR(100)   NOT NULL,
  `item_description` LONGTEXT       NOT NULL,
  `item_quantity`    DECIMAL(10, 2) NOT NULL,
  `item_price`       DECIMAL(10, 2) NOT NULL,
  `item_order`       INT(2)         NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `quote_id` (`quote_id`, `item_date_added`, `item_order`),
  KEY `item_tax_rate_id` (`item_tax_rate_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quote_tax_rates` (
  `quote_tax_rate_id`     INT(11)        NOT NULL AUTO_INCREMENT,
  `quote_id`              INT(11)        NOT NULL,
  `tax_rate_id`           INT(11)        NOT NULL,
  `include_item_tax`      INT(1)         NOT NULL DEFAULT '0',
  `quote_tax_rate_amount` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`quote_tax_rate_id`),
  KEY `quote_id` (`quote_id`),
  KEY `tax_rate_id` (`tax_rate_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_quotes` (
  `quote_id`            INT(11)     NOT NULL AUTO_INCREMENT,
  `invoice_id`          INT(11)     NOT NULL DEFAULT '0',
  `user_id`             INT(11)     NOT NULL,
  `client_id`           INT(11)     NOT NULL,
  `invoice_group_id`    INT(11)     NOT NULL,
  `quote_status_id`     TINYINT(2)  NOT NULL DEFAULT '1',
  `quote_date_created`  DATE        NOT NULL,
  `quote_date_modified` DATETIME    NOT NULL,
  `quote_date_expires`  DATE        NOT NULL,
  `quote_number`        VARCHAR(20) NOT NULL,
  `quote_url_key`       CHAR(32)    NOT NULL,
  PRIMARY KEY (`quote_id`),
  KEY `user_id` (`user_id`, `client_id`, `invoice_group_id`, `quote_date_created`, `quote_date_expires`, `quote_number`),
  KEY `invoice_id` (`invoice_id`),
  KEY `quote_status_id` (`quote_status_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_settings` (
  `setting_id`    INT(11)     NOT NULL AUTO_INCREMENT,
  `setting_key`   VARCHAR(50) NOT NULL,
  `setting_value` LONGTEXT    NOT NULL,
  PRIMARY KEY (`setting_id`),
  KEY `setting_key` (`setting_key`)
)
  ENGINE = MyISAM
  AUTO_INCREMENT = 19
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_tax_rates` (
  `tax_rate_id`      INT(11)       NOT NULL AUTO_INCREMENT,
  `tax_rate_name`    VARCHAR(25)   NOT NULL,
  `tax_rate_percent` DECIMAL(5, 2) NOT NULL,
  PRIMARY KEY (`tax_rate_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_user_clients` (
  `user_client_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`        INT(11) NOT NULL,
  `client_id`      INT(11) NOT NULL,
  PRIMARY KEY (`user_client_id`),
  KEY `user_id` (`user_id`, `client_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_user_custom` (
  `user_custom_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`        INT(11) NOT NULL,
  PRIMARY KEY (`user_custom_id`),
  KEY `user_id` (`user_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_users` (
  `user_id`            INT(11)      NOT NULL AUTO_INCREMENT,
  `user_type`          INT(1)       NOT NULL DEFAULT '0',
  `access_company`     int(11)      DEFAULT 0,
  `user_date_created`  DATETIME     NOT NULL,
  `user_date_modified` DATETIME     NOT NULL,
  `user_name`          VARCHAR(100)          DEFAULT '',
  `user_company`       VARCHAR(100)          DEFAULT '',
  `user_address_1`     VARCHAR(100)          DEFAULT '',
  `user_address_2`     VARCHAR(100)          DEFAULT '',
  `user_city`          VARCHAR(45)           DEFAULT '',
  `user_state`         VARCHAR(35)           DEFAULT '',
  `user_zip`           VARCHAR(15)           DEFAULT '',
  `user_country`       VARCHAR(35)           DEFAULT '',
  `user_phone`         VARCHAR(20)           DEFAULT '',
  `user_fax`           VARCHAR(20)           DEFAULT '',
  `user_mobile`        VARCHAR(20)           DEFAULT '',
  `user_email`         VARCHAR(100) NOT NULL,
  `user_password`      VARCHAR(60)  NOT NULL,
  `user_web`           VARCHAR(100)          DEFAULT '',
  `user_psalt`         CHAR(22)     NOT NULL,
  PRIMARY KEY (`user_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_versions` (
  `version_id`           INT(11)     NOT NULL AUTO_INCREMENT,
  `version_date_applied` VARCHAR(14) NOT NULL,
  `version_file`         VARCHAR(45) NOT NULL,
  `version_sql_errors`   INT(2)      NOT NULL,
  PRIMARY KEY (`version_id`),
  KEY `version_date_applied` (`version_date_applied`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

CREATE TABLE `xc_persons` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(5) NOT NULL,
 `first_name` varchar(40) NOT NULL,
 `middle_name` varchar(40) NOT NULL,
 `last_name` varchar(40) NOT NULL,
 `birthday` varchar(25) NOT NULL,
 `birth_place` varchar(40) NOT NULL,
 `nationality` varchar(40) NOT NULL,
 `language_known` varchar(100) NOT NULL,
 `gender` varchar(10) NOT NULL,
 `home_no` varchar(10) NOT NULL,
 `home_address` varchar(150) NOT NULL,
 `street_address` varchar(100) NOT NULL,
 `city` varchar(50) NOT NULL,
 `country` varchar(50) NOT NULL,
 `zipcode` varchar(10) NOT NULL,
 `email_1` varchar(50) NOT NULL,
 `email_2` varchar(50) NOT NULL,
 `fax` varchar(20) NOT NULL,
 `mobile` varchar(10) NOT NULL,
 `phone_number` varchar(15) NOT NULL,
 `bank_name` varchar(40) NOT NULL,
 `account_number` varchar(25) NOT NULL,
 `bic` varchar(30) NOT NULL,
 `swift_code` varchar(40) NOT NULL,
 `bank_short_code` varchar(40) NOT NULL,
 `routing_number` varchar(40) NOT NULL,
 `person_active` int(11) NOT NULL,
 PRIMARY KEY (`id`)
)
ENGINE = MyISAM
DEFAULT CHARSET = utf8;


CREATE TABLE `xc_categories` (
  `id`      INT(11)       NOT NULL AUTO_INCREMENT,
  `category_name`    VARCHAR(55)   NOT NULL,
  `is_active` int(1) NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

CREATE TABLE `xc_clients_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
   PRIMARY KEY (`id`)
)
ENGINE = MyISAM
DEFAULT CHARSET = utf8;

CREATE TABLE `xc_person_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM
DEFAULT CHARSET = utf8;


CREATE TABLE `xc_client_persons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `telephone_number` varchar(15) NOT NULL,
  `mobile_number` varchar(13) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fax` varchar(15) NOT NULL,
  `office_address` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = MyISAM
DEFAULT CHARSET = utf8;

CREATE TABLE `xc_companies` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `name` varchar(40) NOT NULL,
 `dbname` varchar(40) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET = utf8;

CREATE TABLE `xc_user_companies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id`        INT(11) NOT NULL,
  `company_id`      INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

  ALTER TABLE `xc_user_companies`
  ADD CONSTRAINT `xc_user_companies_user_foreign` FOREIGN KEY (`user_id`) REFERENCES `xc_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `xc_user_companies_company_foreign` FOREIGN KEY (`company_id`) REFERENCES `xc_companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;