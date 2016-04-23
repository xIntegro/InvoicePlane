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

function json_errors()
{
    // Ok, gotta think of a better name for this function. It doesn't return
    // json itself but is called from something which will.

    $return = array();

    foreach (array_keys($_POST) as $key) {
        if (form_error($key)) {
            $return[$key] = form_error($key);
        }
    }

    return $return;
}
