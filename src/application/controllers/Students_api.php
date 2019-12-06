<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
    }

    public function ajax_search_courses(){

    }

    public function ajax_new_plan(){

    }

    public function ajax_save_changes(){

    }

    public function ajax_get_my_plan_info(){

    }

    public function ajax_export_courses(){

    }

    public function ajax_get_all_departments(){

    }

    public function ajax_get_majors(){

    }

    public function ajax_filter_courschemas(){

    }

    public function ajax_get_courschema_info(){

    }

    public function ajax_download_courschema_pdf(){

    }

}