# IP-355 - Overhaul for PDF files, change the old file names to the new ones
UPDATE xc_settings
SET setting_value='Xintegrocore'
WHERE setting_key='pdf_invoice_template' AND
      (setting_value='default' OR setting_value='default-payment' OR setting_value='red' OR setting_value='green');

UPDATE xc_settings
SET setting_value='Xintegrocore - paid'
WHERE setting_key='pdf_invoice_template_paid' AND
      setting_value='default-paid';

UPDATE xc_settings
SET setting_value='Xintegrocore - overdue'
WHERE setting_key='pdf_invoice_template_overdue' AND
      setting_value='default-overdue';

UPDATE xc_settings
SET setting_value='Xintegrocore'
WHERE setting_key='pdf_quote_template' AND
      (setting_value='default' OR setting_value='blue' OR setting_value='red' OR setting_value='green');