<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_master_satuan extends CI_Model
{
	private $table = 'denominations';

    private $validation_rules = array(
        array(
            'field' => 'nama',
            'label' => 'Nama',
            'rules' => 'required|is_unique[denominations.name]',
            'errors' => array(
                'required' => '%s wajib isi',
                'is_unique' => '%s telah digunakan'
            )
        ),
        array(
            'field' => 'size',
            'label' => 'Ukuran',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s wajib isi',
            )
        )
    );

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function create($data)
    {
        $data_insert['name'] = $data['nama'];
        $data_insert['size'] = $data['size'];
        $data_insert['priority'] = $data["priority"];
        
        return $this->utils_model->insert($this->table, $data_insert);
    }

    public function update($id, $data)
    {
        $data_update['name'] = $data["nama"];
        $data_update['size'] = $data["size"];
        $data_update['priority'] = $data["priority"];

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }

    public function get_validation_rules()
    {
        return $this->validation_rules;
    }
}
