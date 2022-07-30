<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * M_roles
 */
class M_roles extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function create()
    {
        $data['name'] = $this->input->post('name');

        return $this->utils_model->insert('roles', $data);
    }

    public function update($id)
    {
        $data_where['id'] = $id;
        $data['name'] = $this->input->post('name');

        return $this->utils_model->update('roles', $data_where, $data);
    }

    public function delete($id)
    {
        $data_where['id'] = $id;

        return $this->utils_model->delete('roles', $data_where);
    }  

    public function update_role($id, $data)
    {
        $data_insert = array();
        $menus_id = explode(", ", $data['menus_id']);

        // generate data_insert
        foreach ($menus_id as $menu_id) {
            array_push($data_insert, 
                array(
                    'id' => uniqid(),
                    'role_id' => $id, 
                    'menu_id' => $menu_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                )
            );
        }

        $this->db->trans_start();
        // delete all data with role_id = $id
        $this->utils_model->delete('menu_roles', array('role_id' => $id));

        // insert batch
        $result = $this->db->insert_batch('menu_roles', $data_insert);
        
        $this->db->trans_complete();

        return $result;
    }
}
 
