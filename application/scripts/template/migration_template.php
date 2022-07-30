<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_template extends CI_Migration {
    public function up()
    {
        $this->dbforge->add_field(array(
            'template_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'template_created_at' => array(
                'type' => 'DATETIME',
            ),
            'template_updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('template_id', TRUE);
        $this->dbforge->create_table('template');
    }

    public function down()
    {
        $this->dbforge->drop_table('template');
    }
}
?>
