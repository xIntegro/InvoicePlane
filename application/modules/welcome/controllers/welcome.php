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
 * @license		https://xintegro.de/license.txt
 * @link		https://xintegro.de
 * 
 */

class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->view('welcome');
    }
}