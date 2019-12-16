<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Collections_api extends CI_Controller{
    public function __construct(){
        parent::__construct();

        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
            $this->security->csrf_show_error();
        }
    }

    public function ajax_get_my_collections(){
        try{
            $user_id = $this->session->userdata('user_id');
            $language = $this->session->userdata('language');
    		$result = $this->collections_model->get_my_collections($language, $user_id);

    		$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}
    }

        
    public function ajax_collect_courschema(){
        try{
            $courschema_id = json_deocde($this->input->post('courschema_id'));
            $user_id       = $this->session->userdata('user_id');

    		$result = $this->collections_model->collect_courschema($courschema_id, $user_id);

    		$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}
    }

    public function ajax_uncollect_courschema(){
        try{
            $courschema_id = json_deocde($this->input->post('courschema_id'));
            $user_id       = $this->session->userdata('user_id');

    		$result = $this->collections_model->uncollect_courschema($courschema_id, $user_id);

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