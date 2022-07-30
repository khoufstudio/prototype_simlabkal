<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_master_golongan extends CI_Model
{
	private $table = 'types';

    private $validation_rules = array(
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|is_unique[types.name]',
            'errors' => array(
                'required' => '%s wajib isi',
                'is_unique' => '%s telah digunakan'
            )
        )
    );

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function create()
    {
        $data['name'] = $this->input->post('nama');
        
        return $this->utils_model->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $data_update['name'] = $data["nama"];

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }

    public function get_validation_rules()
    {
        return $this->validation_rules;
    }
}
 
