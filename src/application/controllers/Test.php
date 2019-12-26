<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Course_model');
		$this->load->model('Data_model');
		$this->load->model('Course_label_model');
		$this->load->model('plans_model');

	}

	public function index(){
		$this->load->library('session');
		echo $this->session->userdata('user_sid') . '<br />';
		echo $this->session->userdata('user_name') . '<br />';
		echo $this->session->userdata('user_email') . '<br />';

		$arr = array(
			'Command 0',
			'Command 1',
			'include 2',
			'Command 3'
		);
		$include_result = array(
			'Command A',
			'Command B'
		);
		for($i = 0; $i < 4; $i++){
			if($arr[$i] == 'include 2'){
				array_splice($arr, $i, 1, $include_result);
			}
		}
		foreach($arr AS $command){
			echo $command . '<br />';
		}
	}

	public function add_one_course_record_test(){

		$this->Course_model->add_one_course('人工智能', 'Artificial intelligence', 'CS303', 1,
			3, 0, 4,
			'1/2/3', 'Both', 'AI课贼爽！！', 'AI class cool!');
		echo 'great';
	}

	public function add_one_department(){
		$this->Department_model->add_one_department('MIKE', '麦克系', 'mike phone');
		echo 'great';
	}

	public function add_course_record_by_excel(){
		$this->Course_model->add_course_record_by_excel('E:\Users\77479\Desktop\test.xlsx');
		echo 'great';
	}

	public function testing(){
		$result = $this->Course_model->query_courses_by_user('11710101');
		print_r($result);
	}

	public function test(){
		print_r($this->plans_model->add_plan('11710101', '我的计划'));

	}


}

?>
