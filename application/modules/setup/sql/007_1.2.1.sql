# Insert default value for read_only_toggle in xc_settings
INSERT INTO `xc_settings` (`setting_key`, `setting_value`)
VALUES ('read_only_toggle', 'paid');

# Update the period settings
UPDATE `xc_settings`
SET `setting_value` = "this-month"
WHERE `setting_value` = "month";
UPDATE `xc_settings`
SET `setting_value` = "this-year"
WHERE `setting_value` = "year";

# Solves IP-198
ALTER TABLE xc_tax_rates CHANGE tax_rate_name tax_rate_name VARCHAR(60) NOT NULL;
