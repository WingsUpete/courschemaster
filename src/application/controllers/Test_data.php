<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Test_data extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Course_model');
		$this->load->model('data_model');
	}

	public function import_test_courses()
	{

		try {
			//variables
			$dep_id_arr = array();
			$ptr = 0;

			$this->data_model->clean_tables();

//		echo 'clear table successfully!!';
//		echo '<br>';
//		echo '<br>';

			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('CSE', '计算机科学与工程系',
				'Department of Computer Science and Engineering');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('MATH', '数学系',
				'Department of Mathematics');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('PHY', '物理系',
				'Department of Physics');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('CHEM', '化学系',
				'Department of Chemistry');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('BIO', '生物系',
				'Department of Biology');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('SPORT', '体育中心',
				'Sports Center');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('SZ', '思想政治教育与研究中心',
				'Center for Ideological and Political Education and Research');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('CLE', '语言中心',
				'Center for Language Education');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('RW', '人文科学中心',
				'Center for the Humanities');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('IAS', '社会科学中心',
				'Center for Social Sciences');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('GE', '教学与公共基础课部',
				'Teaching and Public Foundation Courses');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('CHER', '高等教育研究中心',
				'Center for Higher Education Research');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('ART', '艺术中心',
				'Arts Center');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('EEE', '电子与电气工程系',
				'Department of Electrical and Electronic Engineering');
			$dep_id_arr[$ptr++] = $this->data_model->add_one_department('SAD', '学生工作部',
				'Student Affairs Department');

//		echo 'import the department info successfully!';
//		echo '<br>';
//		echo '<br>';

			$majors_data = array(
				array('name' => '计算机科学与技术', 'en_name' => 'Computer Science and Techonology', 'id_departments' => $dep_id_arr[0]),
				array('name' => '微电子科学与工程', 'en_name' => 'Microelectronics Science and Engineering', 'id_departments' => $dep_id_arr[13]),
				array('name' => '化学', 'en_name' => 'Chemistry', 'id_departments' => $dep_id_arr[3])
			);
			echo $this->data_model->add_majors_batch($majors_data) ? 'Import majors successfully<br /> <br />' : 'Fail to import majors <br /> <br />';

			$this->Course_model->add_course_record_by_excel(dirname(__FILE__) .
				"\..\..\../test_data/general_2017.xlsx");

//		echo 'import general courses successfully!';
//		echo '<br>';
//		echo '<br>';

			$this->Course_model->add_course_record_by_excel(dirname(__FILE__) .
				"\..\..\../test_data/cs_2017.xlsx");

//		echo '<br>';
//		echo '<br>';
//		echo 'import cs2017 courses successfully!';
//		echo '<br>';
//		echo '<br>';

			$this->Course_model->add_course_record_by_excel(dirname(__FILE__) .
				"\..\..\../test_data/cs_2018.xlsx");

			$view = ['success' => TRUE];
			$this->load->view('general/import_data', $view);

//		echo '<br>';
//		echo '<br>';
//		echo 'import cs2018 courses successfully!';
//		echo '<br>';
//		echo '<br>';
		} catch (Exception $exc) {
			$view = ['success' => FALSE, 'exception' => $exc->getMessage()];
		}

		$this->load->view('general/import_data', $view);
	}

}

?>
