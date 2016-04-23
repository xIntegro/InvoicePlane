<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Xintegrocore
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegrocore
 * @author		dhaval (www.codeembassy.in	)
 * @copyright	Copyright (c) 2012 - 2015 xintegrocore.com
 * @license		https://xintegrocore.com/license.txt
 * @link		https://xintegrocore.com
 * 
 */

class Lib_mysql
{
    function connect($server, $username, $password)
    {
        if (!$server or !$username) {
            return FALSE;
        }

        if (@mysqli_connect($server, $username, $password)) {
            return mysqli_connect($server, $username, $password);
        }

        return FALSE;
    }

    function select_db($link, $database)
    {
        if (@mysqli_select_db($link, $database)) {
            return TRUE;
        }

        return FALSE;
    }

    function query($link, $sql)
    {
        $result = mysqli_query($link, $sql);

        return mysqli_fetch_object($result);
    }

}
