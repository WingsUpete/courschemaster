<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test_data extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Course_model');
		$this->load->model('Department_model');
	}

	public function import_test_courses(){

		$this->Department_model->clean_tables();

		echo 'clear cm_departments successfully!!';
		echo '<br>';
		echo '<br>';

		$this->Department_model->add_one_department('CSE', '计算机科学与工程系',
			'Department of Computer Science and Engineering');
		$this->Department_model->add_one_department('MATH', '数学系',
			'Department of Mathematics');
		$this->Department_model->add_one_department('PHY', '物理系',
			'Department of Physics');
		$this->Department_model->add_one_department('CHEM', '化学系',
			'Department of Chemistry');
		$this->Department_model->add_one_department('BIO', '生物系',
			'Department of Biology');
		$this->Department_model->add_one_department('SPORT', '体育中心',
			'Sports Center');
		$this->Department_model->add_one_department('SZ', '思想政治教育与研究中心',
			'Center for Ideological and Political Education and Research');
		$this->Department_model->add_one_department('CLE', '语言中心',
			'Center for Language Education');
		$this->Department_model->add_one_department('RW', '人文科学中心',
			'Center for the Humanities');
		$this->Department_model->add_one_department('IAS', '社会科学中心',
			'Center for Social Sciences');
		$this->Department_model->add_one_department('GE', '教学与公共基础课部',
			'Teaching and Public Foundation Courses');
		$this->Department_model->add_one_department('CHER', '高等教育研究中心',
			'Center for Higher Education Research');
		$this->Department_model->add_one_department('ART', '艺术中心',
			'Arts Center');
		$this->Department_model->add_one_department('EEE', '电子与电气工程系',
			'Department of Electrical and Electronic Engineering');

		echo 'import the department info successfully!';
		echo '<br>';
		echo '<br>';

		$this->Course_model->add_course_record_by_excel(dirname(__FILE__).
			"\..\..\../test_data/general_2017.xlsx");

		echo 'import general courses successfully!';
		echo '<br>';
		echo '<br>';

		$this->Course_model->add_course_record_by_excel(dirname(__FILE__).
			"\..\..\../test_data/cs_2017.xlsx");

		echo '<br>';
		echo '<br>';
		echo 'import cs2017 courses successfully!';
		echo '<br>';
		echo '<br>';

	}

}

?>
