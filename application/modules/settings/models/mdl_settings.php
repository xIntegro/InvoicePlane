<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Xintegrocore
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegrocore
 * @author		xintegro (xintegro.de)
 * @copyright	Copyright (c) 2012 - 2015 xintegro.de
 * @license		http://xintegro.de/license.txt
 * @link		https://xintegro.de
 * 
 */

class Mdl_Settings extends CI_Model
{
    public $settings = array();

    public function get($key)
    {
        $this->db->select('setting_value');
        $this->db->where('setting_key', $key);
        $query = $this->db->get('xc_settings');

        if ($query->row()) {
            return $query->row()->setting_value;
        } else {
            return NULL;
        }
    }

    public function save($key, $value)
    {
        $db_array = array(
            'setting_key' => $key,
            'setting_value' => $value
        );

        if ($this->get($key) !== NULL) {
            $this->db->where('setting_key', $key);
            $this->db->update('xc_settings', $db_array);
        } else {
            $this->db->insert('xc_settings', $db_array);
        }
    }

    public function delete($key)
    {
        $this->db->where('setting_key', $key);
        $this->db->delete('xc_settings');
    }

    public function load_settings()
    {
        $xc_settings = $this->db->get('xc_settings')->result();

        foreach ($xc_settings as $data) {
            $this->settings[$data->setting_key] = $data->setting_value;
        }
    }

    public function setting($key)
    {
        return (isset($this->settings[$key])) ? $this->settings[$key] : '';
    }

    public function set_setting($key, $value)
    {
        $this->settings[$key] = $value;
    }

}
