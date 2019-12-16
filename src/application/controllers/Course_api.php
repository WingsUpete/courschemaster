<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Course_api extends CI_Controller{
	public function __construct(){
		parent::__construct();

		if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
		{
			$this->security->csrf_show_error();
		}
		$this->load->library('session');
		$this->load->model('course_model');
	}

	/**
	 *  this ajax is used to get all the course id with the label for a courschema
	 */
	public function ajax_get_course_id_by_label(){
		try{
			$courschema_id = json_decode($this->input->post('courschema'));
			$label = json_decode($this->input->post('label'));

			$result = $this->course_model->get_course_id_by_label($courschema_id, $label);

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
