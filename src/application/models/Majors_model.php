<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Majors_model extends CI_Model{

    public function get_visible_majors($user_id, $language){
        $this->load->model('users_model');
        $dep_id = $this->users_model->get_dep_id($user_id);
        
        if($language == 'english'){
            $this->db->select('cm_majors.en_name AS name');
        }else{
            $this->db->select('cm_majors.name    AS name');
        }

        return $this->db->select('
                cm_majors.id AS id
            ')
            ->from('cm_majors')
            ->where('cm_majors.id_departments', $dep_id)
            ->get()
            ->result_array();
    }
}