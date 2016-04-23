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

class Form_Validation_Model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;
    }

}

?>