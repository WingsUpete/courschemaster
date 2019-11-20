<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_fields_in_cm_courses extends CI_Migration{

    public function up(){
        //
        $field = [
            'experiment_credit' => [
                'type' => 'FLOAT'
            ],
            'weekly_period' => [
                'type' => 'FLOAT'
            ],
            'semester' => [
                'type' => 'VARCHAR',
                'constraint' => 32
            ],
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => 32
            ],
            'description_cn' => [
                'type' => 'VARCHAR',
                'constraint' => 1024
            ],
            'description_en' => [
                'type' => 'VARCHAR',
                'constraint' => 1024
            ]
        ];
        $this->dbforge->add_column('cm_courses',  $field);
        
        $this->db->update('cm_courses', ['experiment_credit' => 0.0]);  
        $this->db->update('cm_courses', ['weekly_period' => 0.0]); 
        $this->db->update('cm_courses', ['semester' => 'Spring']); 
        $this->db->update('cm_courses', ['language' => 'English']); 
        $this->db->update('cm_courses', ['description_cn' => '没有描述']); 
        $this->db->update('cm_courses', ['description_en' => 'no description']);       
    }

    public function down(){
        $this->drop_column('cm_courses', 'experiment_credit');
        $this->drop_column('cm_courses', 'weekly_period');
        $this->drop_column('cm_courses', 'semester');
        $this->drop_column('cm_courses', 'language');
        $this->drop_column('cm_courses', 'description_en');
        $this->drop_column('cm_courses', 'description_cn');
    }

    protected function drop_column($table, $field){
        if( $this->db->field_exists($field, $table)){
            $this->dbforge->drop_column($table, $field);
        }
    }
}


?>