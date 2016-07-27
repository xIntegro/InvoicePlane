<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

class Mdl_Sessions extends CI_Model
{

    public function auth($email, $password)
    {
        $this->defaultDB = $this->load->database('default', true);
        $this->defaultDB->where('user_email', $email);

        $query = $this->defaultDB->get('xc_users');

        if ($query->num_rows()) {
            $user = $query->row();

            $this->load->library('crypt');

            /**
             * Password hashing changed after 1.2.0
             * Check to see if user has logged in since the password change
             */
            if (!$user->user_psalt) {
                /**
                 * The user has not logged in, so we're going to attempt to
                 * update their record with the updated hash
                 */
                if (md5($password) == $user->user_password) {
                    /**
                     * The md5 login validated - let's update this user
                     * to the new hash
                     */
                    $salt = $this->crypt->salt();
                    $hash = $this->crypt->generate_password($password, $salt);

                    $db_array = array(
                        'user_psalt' => $salt,
                        'user_password' => $hash
                    );

                    $this->defaultDB->where('user_id', $user->user_id);
                    $this->defaultDB->update('xc_users', $db_array);

                    $this->defaultDB->where('user_email', $email);
                    $user = $this->defaultDB->get('xc_users')->row();

                } else {
                    /**
                     * The password didn't verify against original md5
                     */
                    return false;
                }
            }
    
            if ($this->crypt->check_password($user->user_password, $password)) {
                $this->load->model('users_company/mdl_user_company');
                $userCompany = $this->mdl_user_company->getFirstUserCompany($user->user_id);
                $this->defaultDB->where('id', $userCompany->company_id);
                $company = $this->defaultDB->get('xc_companies')->row();
                $dbName = $company->dbname;
                $session_data = array(
                    'user_type' => $user->user_type,
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'user_email' => $user->user_email,
                    'user_company' => $company->name,
                    'company_id' => $company->id,
                    'dbName' => $dbName,
                    'userAccess' => $user->access_company
                );

                $this->session->set_userdata($session_data);

                return true;
            }
        }

        return false;
    }

}
