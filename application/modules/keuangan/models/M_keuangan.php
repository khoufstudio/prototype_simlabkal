<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_keuangan extends CI_Model
{
  private $table = 'finances';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function create()
    {
        $data['finance_type'] = $this->input->post('finance_type');
        $data['name_income_expense'] = $this->input->post('name_income_expense');
        $data['total'] = rupiahToInt($this->input->post('total'));
        $data['description'] = $this->input->post('deskripsi');
        
        return $this->utils_model->insert($this->table, $data);
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
}
 
