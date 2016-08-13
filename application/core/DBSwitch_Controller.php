<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


/**
 * Created by PhpStorm.
 * User: Dharmesh-infyom
 * Date: 6/24/2016
 * Time: 10:39 AM
 */
class DBSwitch_Controller extends Base_Controller
{
    public function __construct($dbName)
    {
        $this->load->library('session');
        $mainDB = $this->load->database('default', true);
        $db = $mainDB->database;
        $this->session->set_userdata('dbName', $mainDB->database);
        parent::__construct();


        try {
            $previousDB = $this->session->userdata('dbName');

            $path = APPPATH . 'modules/setup/sample-sql/xintegro.sql';

            $filename = $path;
            $mysql_host = $mainDB->hostname;
            $mysql_username = $mainDB->username;
            $mysql_password = $mainDB->password;
            $mysql_database = $dbName;

            mysql_connect($mysql_host, $mysql_username,
                $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
            mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());
            $templine = '';

            $lines = file($filename);

            foreach ($lines as $line) {

                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                $templine .= $line;

                if (substr(trim($line), -1, 1) == ';') {
                    // Perform the query
                    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
                    // Reset temp variable to empty
                    $templine = '';
                }
            }

            $switchCOnn = $previousDB;

        } catch (Exception $e) {
            if (isset($previousDB)) {
                $switchCOnn = new DBSwitch_Controller($previousDB);
            }
        }
    }
}