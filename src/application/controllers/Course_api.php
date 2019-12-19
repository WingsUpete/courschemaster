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
	 * this ajax is used to add courses by excel
	 */
	public function ajax_add_courses_by_excel(){
		try{
			$file = $_FILES['target_file'];
			$name = $file['name'];
			$temp_name = $file['tmp_name'];
			$type = $file['type'];
			$error = $file['error'];
			$size = $file['size'];

			$result = $this->course_model->add_course_record_by_excel($temp_name);

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
	 * this ajax is used to delete one course by course code
	 */
	public function ajax_delete_one_course_by_course_code(){
		try{
			$code = json_decode($this->input->post('code'));

			$result = $this->course_model->delete_one_course($code);

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
	 * this ajax is used to add one course to the database
	 */
	public function ajax_add_one_course(){
		$msg = array();

		try{
			$name = json_decode($this->input->post('name'));

			$en_name = json_decode($this->input->post('en_name'));

			$code = json_decode($this->input->post('code'));
			$query = $this->db
				->select('*')
				->from('cm_courses')
				->where('cm_courses.code', $code)
				->get();
			if($query->num_rows() > 0){
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(['messages' => 'the course code already in']));
				$msg['status'] = 'fail';
				$msg['message'] = 'the code of course already exists.';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($msg));
				return;
			}

			$department_code = json_decode($this->input->post('department_code'));
			$course_department_id = 0;
			$query = $this->db
				->select('*')
				->from('cm_departments')
				->where('cm_departments.code', $department_code)
				->get();

			foreach ($query->result() as $row)
			{
				$course_department_id = $row->id;
			}
			if($course_department_id == 0){
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(['messages' => 'the department code is not exist']));
				$msg['status'] = 'fail';
				$msg['message'] = 'the code of department not exists.';
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($msg));
				return;
			}

			$credit = json_decode($this->input->post('credit'));
			$credit = (float)$credit;

			$exp_credit = json_decode($this->input->post('exp_credit'));
			$exp_credit = (float)$exp_credit;

			$weekly_period = json_decode($this->input->post('weekly_period'));
			$weekly_period = (float)$weekly_period;

			$semester = json_decode($this->input->post('semester'));
			$course_semester_temp = $semester;
			$semester = '';
			if ( (strpos($course_semester_temp, '2') !== false) or
				(strpos($course_semester_temp, '春') !== false) or
				(strpos($course_semester_temp, 'spring') !== false)){
				$semester = $semester.'2; ';
			}
			if ( (strpos($course_semester_temp, '3') !== false) or
				(strpos($course_semester_temp, '夏') !== false) or
				(strpos($course_semester_temp, 'summer') !== false)){
				$semester = $semester.'3; ';
			}
			if ( (strpos($course_semester_temp, '1') !== false) or
				(strpos($course_semester_temp, '秋') !== false) or
				(strpos($course_semester_temp, 'fall') !== false)){
				$semester = $semester.'1; ';
			}

			$language = json_decode($this->input->post('language'));
			$course_language_temp = $language;
			$language = '';
			if ( (strpos($course_language_temp, '中文') !== false) or
				(strpos($course_language_temp, 'cn') !== false) or
				(strpos($course_language_temp, 'C') !== false) or
				(strpos($course_language_temp, 'chinese') !== false)){
				$language = $language.'C; ';
			}
			if ( (strpos($course_language_temp, '英文') !== false) or
				(strpos($course_language_temp, 'en') !== false) or
				(strpos($course_language_temp, 'E') !== false) or
				(strpos($course_language_temp, 'english') !== false)){
				$language = $language.'E; ';
			}
			if ( (strpos($course_language_temp, '中英文') !== false) or
				(strpos($course_language_temp, 'both') !== false) or
				(strpos($course_language_temp, 'B') !== false)){
				$language = $language.'B; ';
			}

			$description = json_decode($this->input->post('description'));

			$en_description = json_decode($this->input->post('en_description'));

			$pre_logic = json_decode($this->input->post('pre_logic'));
			$pre_logic = str_replace(' ', '', $pre_logic);
			$pre_logic = str_replace('\r', '', $pre_logic);
			$pre_logic = str_replace('\n', '', $pre_logic);
			$pre_logic = str_replace('\t', '', $pre_logic);

			$this->course_model->add_one_course($name, $en_name, $code, $course_department_id,
				$credit, $exp_credit, $weekly_period,
				$semester, $language, $description, $en_description, $pre_logic);

			$msg['status'] = 'success';
			$msg['message'] = 'add the course successfully.';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($msg));

		}catch (Exception $exc){
			$msg['status'] = 'fail';
			$msg['message'] = 'exception happens.';
			$msg['exceptions'] = [exceptionToJavaScript($exc)];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($msg));
		}
	}

	/**
	 * this method is used to get all the courses information to initialize the course management page
	 */
	public function ajax_get_all_course_full_info(){
		try{
			$result = $this->course_model->get_all_course_full_info();

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
	 * this method is used to get all the courses information to initialize the course management page
	 */
	public function ajax_get_all_course_info(){
		try{
			$language = $this->session->userdata('language');
			$result = $this->course_model->get_all_course_info($language);

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
	 * this ajax is used to get all the course id by fuzzy search
	 *
	 * the $match is used to matching the cn_name, en_name or code
	 */
	public function ajax_get_course_id_by_fuzzy_search(){
		try{
			$match = json_decode($this->input->post('match'));

			$result = $this->course_model->get_course_id_by_fuzzy_search($match);

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
