<?php defined('BASEPATH') OR exit('No direct script access allowed');

function check_installation_status(){
    $ci =& get_instance();
    return $ci->db->table_exists('cm_users');
}