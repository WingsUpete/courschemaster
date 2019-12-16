<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Students_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
    }

    public function ajax_get_my_learned(){
        try{

            $user_id = $this->session->userdata('user_id');

            $result = $this->course_model->get_my_learned($user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result)); 

        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }
}