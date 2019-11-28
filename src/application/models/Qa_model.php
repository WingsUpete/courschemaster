<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qa_model extends CI_Model{
    public function post_question($labels, $title, $description, $user_id,  $autentication){
        $timestamp_datetime = new DateTime('NOW');
        $timestamp        = $timestamp_datetime->format('Y-m-d H:i:s');
        $default_view_cnt = 0;

        
    }
}