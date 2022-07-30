<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_opname extends CI_Model
{
	private $table = 'opnames';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
	
	public function create($data) 
    {
        $data_insert['product_id'] = explode("|", $data['barang'])[0];
        $data_insert['stock_current'] = $data['stok_asal'];
        $data_insert['stock_real_current'] = $data['stok_barang'];
        $data_insert['reason'] =  $data['alasan'];
   
        return $this->utils_model->insert($this->table, $data_insert);

    }
    public function laporan_opname()
    {
        $date = $this->input->post('periode');
        $date = explode(" - ", $date);
        $tanggalAwal = str_replace("/", "-", $date[0]);
        $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
        $tanggalAkhir = str_replace("/", "-", $date[1]);
        $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
        $whereRaw = "o.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";

        $this->db
            ->select("
                o.*
                , p.name product_name
                , p.selling_price
                , DATE_FORMAT(o.created_at, '%d/%m/%Y %H:%i') AS tanggal_buat,
            ")
            ->from($this->table . ' o')
            ->join('products p', 'o.product_id = p.id')
            ->where($whereRaw)
            ;
        return $this->db->get()->result_array();
    }
}
