<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model{
    public function get_dep_id($user_id){
        return $this->db->select('
                cm_majors.id_departments AS dep_id
            ')
            ->from('cm_users')
            ->join('cm_majors', 'cm_users.id_majors = cm_majors.id', 'inner')
            ->where('cm_users.id', $user_id)
            ->get()
            ->row_array()['dep_id'];
    }

    public function get_name($user_id){
        return $this->db->select('
                cm_users.name AS name
            ')
            ->from('cm_users')
            ->where('cm_users.id', $user_id)
            ->get()
            ->row_array()['name'];
    }
}