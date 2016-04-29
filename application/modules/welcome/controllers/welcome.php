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

class Welcome extends CI_Controller
{
    public function index()
    {
        $this->load->view('welcome');
    }
}