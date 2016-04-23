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

class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->view('welcome');
    }
}