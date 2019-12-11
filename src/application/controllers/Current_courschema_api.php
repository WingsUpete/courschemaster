<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Current_courschema_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
        $this->load->library('session');
        $this->load->model('courschemas_model');
		$this->load->model('course_model');
    }

    public function ajax_get_ccBasic(){
        try{

            $language = $this->session->userdata('language');
            $user_id  = $this->session->userdata('user_id');

            $result = $this->courschemas_model->get_ccBasic($language, $user_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    public function ajax_get_pdf(){
        try{

            $courschema_id = json_deocde($this->input->post('courschema_id'));

            $result = $this->courschemas_model->get_pdf($language, $courschema_id);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(asset_url('data/courschema_pdf/'.$result)));
        }catch(Exception $exc){
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
        }
    }

    // unchecked, waited for the format of filter
    public function ajax_get_courses(){
    	try{
    		$filter = json_deocde($this->input->post('filter'));

    		$result = $this->course_model->query_courses_by_filter($language, $filter);

    		$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}
	}
}
