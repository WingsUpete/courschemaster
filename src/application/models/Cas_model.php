<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cas_model extends CI_Model{

    /**
     * @param cas_user_data email, groups, id, name, sid
     */
    public function get_user_data($cas_user_data){

        $default_registraion_id_privileges = 1;

        $id_users = -1;

        $registration = 
            $this->db->select('COUNT(*)')
                ->from('cm_users')
                ->where('cm_users.cas_hash_id', $cas_user_data['id'])
                ->get()
                ->row_array()['COUNT(*)'];

        // User has not registered yet ?
        if($registration == 0){

            // Register

            $this->db->trans_begin();

            $data = array(
                'name' => $cas_user_data['name'],
                'email' => $cas_user_data['email'],
                'cas_hash_id' => $cas_user_data['id'], 
                'cas_sid' => $cas_user_data['sid'],
                'id_privileges' => $default_registraion_id_privileges,
                'id_colleges' => $this->get_college($cas_user_data['sid']),
                'id_majors' => $this->get_major($cas_user_data['sid'])
            );
                
            if($this->db->insert('cm_users', $data)){
                $id_users = $this->db->insert_id();

                $data = array('id_users' => $id_users, 'username' => $cas_user_data['sid']);
                    
                if ( ! $this->db->insert('cm_user_settings', $data) ){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }
            }
            $this->db->trans_complete();
        }


        // Get user data
        $user_data = $this->db
            ->select('
                cm_users.name       AS user_name,
                cm_users.cas_sid    AS user_sid, 
                cm_users.id         AS user_id, 
                cm_users.email      AS user_email, 
                cm_privileges.name  AS role
            ')
            ->from('cm_users')
            ->join('cm_privileges', 'cm_privileges.id = cm_users.id_privileges', 'inner')
            ->join('cm_user_settings', 'cm_user_settings.id_users = cm_users.id', 'inner')
            ->where('cm_users.cas_sid', $cas_user_data['sid'])
            ->get()
            ->row_array();

        return ($user_data) ? $user_data : NULL;
    }

    protected function get_college($sid){
        $result = $this->db->select('
                cm_colleges.id AS id
            ')
            ->from('cm_colleges')
            ->get()
            ->result_array();

        $num = sizeof($result);

        return $result[rand(0, $num - 1)]['id'];
    }

    protected function get_major($sid){
        $result = $this->db->select('
                cm_majors.id AS id
            ')
            ->from('cm_majors')
            ->get()
            ->result_array();

        $num = sizeof($result);

        return $result[rand(0, $num - 1)]['id'];
    }
}
?>