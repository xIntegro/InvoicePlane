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

class Mdl_User_Custom extends MY_Model
{
    public $table = 'xc_user_custom';
    public $primary_key = 'xc_user_custom.user_custom_id';

    public function save_custom($user_id, $db_array)
    {
        $user_custom_id = NULL;

        $db_array['user_id'] = $user_id;

        $user_custom = $this->where('user_id', $user_id)->get();

        if ($user_custom->num_rows()) {
            $user_custom_id = $user_custom->row()->user_custom_id;
        }

        parent::save($user_custom_id, $db_array);
    }

}
