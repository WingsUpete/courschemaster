<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plans_model extends CI_Model{

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

				$result[$plan['name']] = $courses;
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


		print_r($result);

		return $result;

	}
}
