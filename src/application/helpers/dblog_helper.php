<?php defined('BASEPATH') OR exit('No direct script access allowed');

function log_operation($operation, $user_id, $input_arr, $output_arr){
    $ci = &get_instance();

    $timestamp_datetime = new DateTime('NOW');
    $timestamp = $timestamp_datetime->format('Y-m-d H:i:s');

    $data = array(
        'id_users' => $user_id,
        'operation' => $operation,
        'input' => json_encode($input_arr),
        'output' => json_encode($output_arr),
        'timestamp' => $timestamp
    );
    return $ci->db->insert('all_log', $data);
}