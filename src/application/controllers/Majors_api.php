<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Majors_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
		$this->load->library('session');
		$this->load->model('majors_model');
    }

    public function ajax_get_visible_majors(){
        try{

            $user_id = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');

            $result = $this->majors_model->get_visible_majors($user_id, $language);

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