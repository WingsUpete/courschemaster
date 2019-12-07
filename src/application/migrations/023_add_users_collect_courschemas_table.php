<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_users_collect_courschemas_table extends CI_Migration{
    
	public function up(){
        
        $this->db->query('CREATE TABLE `cm_users_collect_courschems` (
            `id_users` INT NOT NULL,
            `id_courschemas` INT NOT NULL,
            PRIMARY KEY (`id_users`, `id_courschemas`),
            INDEX `fk_collections_courschems_idx` (`id_courschemas` ASC),
            CONSTRAINT `fk_collection_users`
              FOREIGN KEY (`id_users`)
              REFERENCES `cm_users` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            CONSTRAINT `fk_collections_courschems`
              FOREIGN KEY (`id_courschemas`)
              REFERENCES `cm_courschemas` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION);
        ');
    }

	public function down(){
        $this->db->query('DROP TABLE cm_users_collect_courschems');
	}
}
?>