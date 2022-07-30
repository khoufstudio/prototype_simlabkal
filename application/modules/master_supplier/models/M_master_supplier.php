<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_master_supplier extends CI_Model
{
	private $table = 'suppliers';

    private $validation_rules = array(
        array(
            'field' => 'nama',
            'label' => 'Nama Supplier',
            'rules' => 'required|is_unique[suppliers.name]',
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

    public function get_supplier_name_by_purchase_id($purchase_id)
    {
        $this->db->select('s.name')
            ->from($this->table . ' as s')
            ->join('purchases p', 'p.supplier_id = s.id')
            ->where('p.id', $purchase_id);

        return $this->db->get()->row_array();
    }

    public function get_validation_rules()
    {
        return $this->validation_rules;
    }
}