<?php defined('BASEPATH') OR exit('No direct script access allowed');

function load_header_data(&$view){
    $ci =& get_instance();
    $view['base_url'] = $ci->config->item('base_url');

    if($ci->session->userdata('user_sid')){
        $view['user_sid'] = $ci->session->userdata('user_sid');
        $view['user_name'] = $ci->session->userdata('user_name');
        $view['logged_in'] = 'true';
    }else{
        $view['logged_in'] = 'false';
        $view['user_sid'] = ' ';
        $view['user_name'] = ' ';
    }
    // Set user's selected language.
    if ($ci->session->userdata('language')){
        $view['language'] = $ci->session->userdata('language');
    }
    else{
        $view['language'] = $ci->config->item('language');
    }
}