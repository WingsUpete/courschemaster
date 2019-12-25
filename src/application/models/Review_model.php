<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends CI_Model{

    public function _get_timestamp(){
        $timestamp_datetime = new DateTime('NOW');
        return $timestamp_datetime->format('Y-m-d H:i:s');
    }

    public function get_review_status($language, $user_id){
        $this->load->model('users_model');
        $user_dep_id = $this->users_model->get_dep_id($user_id);

        if($language == 'english'){
            $this->db->select('
                cm_majors.en_name AS major
            ');
        }else{
            $this->db->select('
                cm_majors.name AS major
            ');
        }

        $result =  $this->db->select('
                cm_review.id                AS review_id,
                cm_courschemas.id           AS courschema_id,
                cm_courschemas.name         AS courschema_name,
                cm_review.status            AS status,
                cm_review.comment           AS comment,
                poster.name                 AS poster_name,
                cm_review.post_timestamp    AS post_time,
                cm_review.id_users_reviewer AS reviewer_id,
                cm_review.review_timestamp  AS review_time
            ')
            ->from('cm_review')
            ->join('cm_users AS poster', 'poster.id = cm_review.id_users_poster', 'inner')
            ->join('cm_courschemas', 'cm_review.id_courschemas = cm_courschemas.id', 'inner')
            ->join('cm_majors', 'cm_majors.id = cm_courschemas.id_majors', 'inner')
            ->where('cm_majors.id_departments', $user_dep_id)
            ->get()
            ->result_array();

        for($i = 0; $i < sizeof($result); $i++){
            if($result[$i]['reviewer_id']){
                $result[$i]['reviewer_name'] = $this->users_model->get_name($result[$i]['reviewer_id']);
            }else{
                $result[$i]['reviewer_name'] = '新 宝 岛';
                $result[$i]['review_time'] = '我们遇到什么困难，都不要怕；削面恐惧的最好办法，就是面对它。';
            }
            unset($result[$i]['reviewer_id']);
        }
        return $result;
    }

    public function get_tao_review_list($language, $user_id){
        $this->load->model('users_model');
        if($language == 'english'){
            $this->db->select('
                cm_majors.en_name AS major
            ');
        }else{
            $this->db->select('
                cm_majors.name AS major
            ');
        }

        $result = $this->db->select('
            cm_review.id                AS review_id,
            cm_courschemas.name         AS courschemas_name,
            cm_courschemas.id           AS courschemas_id,
            cm_review.comment           AS comment,
            poster.name                 AS poster_name,
            cm_review.post_timestamp    AS post_time,
            cm_review.id_users_reviewer AS reviewer_id,
            cm_review.review_timestamp  AS review_time,
            cm_review.status            AS status,
            cm_courschemas.pdf_url      AS pdf_file_name 
        ')
        ->from('cm_review')
        ->join('cm_courschemas', 'cm_courschemas.id = cm_review.id_courschemas', 'inner')
        ->join('cm_majors', 'cm_courschemas.id_majors = cm_majors.id', 'inner')
        ->join('cm_users AS poster', 'poster.id = cm_review.id_users_poster', 'inner')
        ->get()
        ->result_array();

        for($i = 0; $i < sizeof($result); $i++){
            if($result[$i]['reviewer_id']){
                $result[$i]['reviewer_name'] = $this->users_model->get_name($result[$i]['reviewer_id']);
            }else{
                $result[$i]['reviewer_name'] = '新 宝 岛';
                $result[$i]['review_time'] = '我们遇到什么困难，都不要怕；削面恐惧的最好办法，就是面对它。';
            }
            unset($result[$i]['reviewer_id']);
        }

        for($i = 0; $i < sizeof($result); $i++){
            $url = $result[$i]['pdf_file_name'];
            $result[$i]['pdf_url'] = asset_url('assets/pdf/' . $url);
            $result[$i]['download_link'] = base_url('index.php/download/pdf/'.$url);
            unset($result[$i]['pdf_file_name']);
        }

        return $result;
    }

    public function review_reject_courschema($user_id, $review_id, $comment){
        $result = $this->_review_courschema($user_id, $review_id, $comment, 0);
        log_operation('review_accept_courschema', $user_id, array('user_id'=>$user_id, 'review_id'=>$review_id, 'comment'=>$comment), $result);
        return $result;
    }

    public function review_accept_courschema($user_id, $review_id, $comment){
        $result = $this->_review_courschema($user_id, $review_id, $comment, 1);
        log_operation('review_accept_courschema', $user_id, array('user_id'=>$user_id, 'review_id'=>$review_id, 'comment'=>$comment), $result);
        return $result;
    }

    public function _review_courschema($user_id, $review_id, $comment, $is_available){
        $data_updated = array(
            'comment' => $comment,
            'id_users_reviewer' => $user_id,
            'review_timestamp' => $this->_get_timestamp(),
            'status' => $is_available ? 'accepted' : 'rejected'
        );
        $this->db->trans_begin();
        
        $this->db->where('cm_review.id', $review_id);
        $this->db->update('cm_review', $data_updated);

        $courschema_id = $this->db->select('
                cm_review.id_courschemas AS courschema_id
            ')
            ->from('cm_review')
            ->where('cm_review.id', $review_id)
            ->get()
            ->row_array()['courschema_id'];

        $this->db->where('cm_courschemas.id', $courschema_id);
        $result = $this->db->update('cm_courschemas', array('is_available' => $is_available));
            
            
        if($result){
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }
        $this->db->trans_complete();
        return $result;
    }
}