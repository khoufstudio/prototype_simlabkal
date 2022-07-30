<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_master_pelanggan extends CI_Model
{
	private $table = 'customers';

    private $validation_rules = array(
        array(
            'field' => 'nama',
            'label' => 'Nama Pelanggan',
            'rules' => 'required|is_unique[customers.name]',
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

    public function create($data)
    {
        $data_insert['name'] = $data['nama'];
        $data_insert['address'] = $data['alamat'];
        $data_insert['contact'] = $data['nomor_kontak'];
        
        return $this->utils_model->insert($this->table, $data_insert);
    } 

    public function update($id, $data)
    {
        $data_update['name'] = $data["nama"];
        $data_update['address'] = $data["alamat"];
        $data_update['contact'] = $data["nomor_kontak"];

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }

    public function get_customer_name_by_selling_id($selling_id)
    {
        $this->db->select('c.name')
            ->from($this->table . ' as c')
            ->join('sellings s', 's.customer_id = c.id')
            ->where('s.id', $selling_id);

        return $this->db->get()->row_array();
    }

    public function get_validation_rules()
    {
        return $this->validation_rules;
    }
}
 
