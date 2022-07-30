<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_customers extends CI_Migration {
    public function up()
    {
        $this->dbforge->add_field(array(
            'customers_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'customers_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'customers_address' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'customers_contact' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'customers_created_at' => array(
                'type' => 'DATETIME',
            ),
            'customers_updated_at' => array(
                'type' => 'DATETIME',
            ),
        ));
        $this->dbforge->add_key('customers_id', TRUE);
        $this->dbforge->create_table('customers');
    }

    public function down()
    {
        $this->dbforge->drop_table('customers');
    }
}
?>
