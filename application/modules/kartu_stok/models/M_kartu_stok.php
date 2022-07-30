<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_kartu_stok extends CI_Model
{
	private $table = 'card_stocks';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
	
	public function create($data) 
    {
        $data_insert['transaction_code'] = $data['transaction_code'];
        $data_insert['product_id'] = $data['product_id'];
        $data_insert['supplier_name'] = $data['supplier_name'];
        $data_insert['quantity'] = $data['quantity'];
        $data_insert['stock'] = $data['stock'];
        $data_insert['expired_date'] = $data['expired_date'];
   
        return $this->utils_model->insert($this->table, $data_insert);

    }

    public function kartu_stok_print($product_id, $periode)
    {
        $date = explode(" - ", $periode);
        $tanggal_awal = str_replace("/", "-", $date[0]);
        $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
        $tanggal_akhir = str_replace("/", "-", $date[1]);
        $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
        $where_periode = "created_at BETWEEN '".$tanggal_awal." 00:00' AND '".$tanggal_akhir." 23:59'";

        $result = $this->db
            ->select("created_at, transaction_code, supplier_name, quantity, stock, expired_date")
            ->from($this->table . ' as c')
            ->where('c.product_id', $product_id)
            ->where($where_periode);

        return $result->get()->result_array();
    }
    
}
