<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Test extends CI_Migration {

    public function up(){
        if( ! $this->db->field_exists('avatar_url', 'cm_users')){
            $field = [
                'avatar_url' => [
                    'type' => 'VARCHAR',
                    'constraint' => '128',
                    'default' => 'default.png'
                ]
            ];
            $this->dbforge->add_column('cm_users', $field);
            $this->db->update('cm_users', ['avatar_url' => 'default.png']);
        }
    }

    public function down(){
        if( $this->db->field_exists('avatar_url', 'cm_users') ){
            $this->dbforge->drop_column('cm_users', 'avatar_url');
        }
    }
}
?>