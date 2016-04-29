<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * xintegro
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegro
 * @author		xintegro (xintegro.de)
 * @copyright	Copyright (c) 2012 - 2015 xintegro.de
 * @license		http://xintegro.de/license.txt
 * @link		http://xintegro.de/
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
