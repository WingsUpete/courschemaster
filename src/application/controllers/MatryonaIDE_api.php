<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MatryonaIDE_api extends CI_Controller{

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
	 * this ajax is used to check courses exists or not
	 * input a list of course id
	 * output a list of boolean
	 */
	public function ajax_check_courses_existence(){

		try{
			$code_list = json_decode($this->input->post('code_list'));
			$result_list = array();

			for ($i = 0; $i < count($code_list); $i++){
				$code = $code_list[$i];
				$result_list[$i] = $this->course_model->one_course_exits_or_not($code);
			}

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result_list));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}

	}

	/**
	 * this ajax is used to find the prerequisites course for courses
	 * input is a list of course code
	 * output is a list of prerequisites relationship
	 */
	public function ajax_find_courses_pre_course(){
		try{
			$code_list = json_decode($this->input->post('code_list'));
			$result_list = array();

			for ($i = 0; $i < count($code_list); $i++){
				$code = $code_list[$i];
				$result_list[$i] = $this->course_model->query_course_pre($code);
			}

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($result_list));

		}catch (Exception $exc){
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(['exceptions' => [exceptionToJavaScript($exc)]]));
		}
	}

}
