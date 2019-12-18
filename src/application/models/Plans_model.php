<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plans_model extends CI_Model{

	/**
	 * this method is used to add a course to a plan
	 *
	 * @param $plan_id: the id of the plan
	 * @param $course_id: the id of the course
	 * @return array: the add movement result
	 */
	public function add_course_to_plan($plan_id, $course_id){
		$msg = array();
		$exits = $this->db
			->select('*')
			->from('cm_plans_courses')
			->where('cm_plans_courses.id_plans', $plan_id)
			->where('cm_plans_courses.id_courses', $course_id)
			->get()->result_array();
		if(sizeof($exits) > 0){
			$msg['status'] = 'fail';
			$msg['message'] = 'the course already exists in the plan.';
			return $msg;
		}

		$exits = $this->db
			->select('*')
			->from('cm_plans')
			->where('cm_plans.id', $plan_id)
			->get()->result_array();
		if(sizeof($exits) == 0){
			$msg['status'] = 'fail';
			$msg['message'] = 'the id of plan not exists.';
			return $msg;
		}

		$exits = $this->db
			->select('*')
			->from('cm_courses')
			->where('cm_courses.id', $course_id)
			->get()->result_array();
		if(sizeof($exits) == 0){
			$msg['status'] = 'fail';
			$msg['message'] = 'the id of course not exists.';
			return $msg;
		}

		$data = array(
			'id_plans' => $plan_id,
			'id_courses' => $course_id
		);

		$this->db->insert('cm_plans_courses', $data);
		$msg['status'] = 'success';
		$msg['message'] = 'add the course to plan successfully.';
		return $msg;

	}

	/**
	 * this method is used to delete one course record from a plan
	 *
	 * @param $plan_id: the id of the plan
	 * @param $course_id: the id of the course
	 * @return bool: successfully or not
	 */
	public function remove_from_my_plan($plan_id, $course_id){
		try{
			$this->db
				->where('cm_plans_courses.id_plans', $plan_id)
				->where('cm_plans_courses.id_courses', $course_id)
				->delete('cm_plans_courses');

			return True;
		}catch (Exception $exc){
			return False;
		}
	}

	/**
	 * This method is used to get all plans info for a user
	 *
	 * @param $user_id: the user id
	 * @param $language: the language of the return message
	 * @return array: the query result
	 */
	public function get_my_plans($user_id, $language){
		$plans = $this->db
			->select('cm_plans.name AS name, cm_plans.id AS id')
			->from('cm_users_plans')
			->join('cm_plans', 'cm_plans.id = cm_users_plans.id_plans')
			->where('cm_users_plans.id_users', $user_id)
			->get()->result_array();

		$result = array();

		if($language == 'english'){
			foreach ($plans as $plan) {
				$courses = $this->db
					->select('cm_courses.id AS course_id,
				cm_courses.code AS course_code,
				cm_courses.en_name AS course_name')
					->from('cm_plans')
					->join('cm_plans_courses', 'cm_plans_courses.id_plans = cm_plans.id')
					->join('cm_courses', 'cm_courses.id = cm_plans_courses.id_courses')
					->where('cm_plans.id', $plan['id'])
					->get()->result_array();

				for ($i = 0; $i<sizeof($courses); $i++){

					$courses[$i]['learned_date'] = 'Not learned yet';
					$courses[$i]['label'] = '';

					$date = $this->db
						->select('cm_users_courses.semester AS semester')
						->from('cm_users_courses')
						->where('cm_users_courses.id_users', $user_id)
						->where('cm_users_courses.id_courses', $courses[$i]['course_id'])
						->get()->result_array();

					if(sizeof($date) > 0){
						$courses[$i]['learned_date'] = $date[0]['semester'];
					}

					$label = $this->db
						->select('cm_course_labels.en_name as name')
						->from('cm_users')
						->join('cm_course_label_courschemas',
							'cm_course_label_courschemas.id_courschemas = cm_users.id_courschemas')
						->join('cm_course_labels', 'cm_course_labels.id = cm_course_label_courschemas.id_labels')
						->where('cm_users.id', $user_id)
						->where('cm_course_label_courschemas.id_courses', $courses[$i]['course_id'])
						->get()->result_array();

					if(sizeof($label) > 0){
						$courses[$i]['label'] = $label[0]['name'];
					}

				}

				$result[$plan['name']]['courses'] = $courses;
				$result[$plan['name']]['plan_id'] = $plan['id'];
			}
		}else{
			foreach ($plans as $plan) {
				$courses = $this->db
					->select('cm_courses.id AS course_id,
				cm_courses.code AS course_code,
				cm_courses.name AS course_name')
					->from('cm_plans')
					->join('cm_plans_courses', 'cm_plans_courses.id_plans = cm_plans.id')
					->join('cm_courses', 'cm_courses.id = cm_plans_courses.id_courses')
					->where('cm_plans.id', $plan['id'])
					->get()->result_array();

				for ($i = 0; $i<sizeof($courses); $i++){

					$courses[$i]['learned_date'] = '还未学习';
					$courses[$i]['label'] = '';

					$date = $this->db
						->select('cm_users_courses.semester AS semester')
						->from('cm_users_courses')
						->where('cm_users_courses.id_users', $user_id)
						->where('cm_users_courses.id_courses', $courses[$i]['course_id'])
						->get()->result_array();

					if(sizeof($date) > 0){
						$courses[$i]['learned_date'] = $date[0]['semester'];
					}

					$label = $this->db
						->select('cm_course_labels.cn_name as name')
						->from('cm_users')
						->join('cm_course_label_courschemas',
							'cm_course_label_courschemas.id_courschemas = cm_users.id_courschemas')
						->join('cm_course_labels', 'cm_course_labels.id = cm_course_label_courschemas.id_labels')
						->where('cm_users.id', $user_id)
						->where('cm_course_label_courschemas.id_courses', $courses[$i]['course_id'])
						->get()->result_array();

					if(sizeof($label) > 0){
						$courses[$i]['label'] = $label[0]['name'];
					}

				}

				$result[$plan['name']] = $courses;
			}
		}

		return $result;

	}
}
