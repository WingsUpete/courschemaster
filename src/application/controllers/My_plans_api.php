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
		if( ! $this->session->userdata('language')){
            $this->session->set_userdata('language', Config::LANGUAGE);
        }
	}

	/**
	 * this ajax used to add a plan to database for a user
	 */
	public function ajax_add_plan(){
		try{
			$user_id = $this->session->userdata('user_id');
			$name = json_decode($this->input->post('plan_name'));
			$id = $this->plans_model->add_plan($user_id, $name);

			$result = array(
				'plan_id' => $id
			);

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
			$plan_id = json_decode($this->input->post('plan_id'));
			$course_id = json_decode($this->input->post('course_id'));

			$result = $this->plans_model->remove_from_my_plan($plan_id, $course_id);

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
	 * this ajax is used to add a course to plan
	 */
	public function ajax_add_course_to_plan(){
		try{
			$plan_id = json_decode($this->input->post('plan_id'));
			$course_id = json_decode($this->input->post('course_id'));

			$result = $this->plans_model->add_course_to_plan($plan_id, $course_id);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result));

		}catch (Exception $exc){
			$msg = array();
			$msg['status'] = 'fail';
			$msg['message'] = 'exception happens.';
			$msg['exceptions'] = [exceptionToJavaScript($exc)];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($msg));
		}


	}



}
