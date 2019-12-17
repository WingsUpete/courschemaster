<?php defined('BASEPATH') OR exit('No direct script access allowed');

class My_plans_api extends CI_Controller{
	public function __construct(){
		parent::__construct();

		if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
		{
			$this->security->csrf_show_error();
		}

		$this->load->library('session');
		$this->load->model('plans_model');
	}

	/**
	 * this ajax is used to get all plans for a user
	 */
	public function ajax_get_my_plans(){
		try{
			$user_id = $this->session->userdata('user_id');
			$language = $this->session->userdata('language');
			$result = $this->plans_model->get_my_plans($user_id, $language);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}
	}

	/**
	 * this ajax is used to remove one course from a plan
	 */
	public function ajax_remove_from_my_plan(){
		try{
			$user_id = $this->session->userdata('user_id');
			$plan_id = json_decode($this->input->post('plan_id'));
			$course_id = json_decode($this->input->post('course_id'));

			$result = $this->plans_model->remove_from_my_plan($user_id, $plan_id, $course_id);

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
