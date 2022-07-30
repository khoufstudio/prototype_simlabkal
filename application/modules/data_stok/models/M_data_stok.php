<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  @author Rizqy
 */
class M_data_stok extends CI_Model
{
    private $table = 'card_stocks';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
    
    public function data_stok_print($product_id, $periode)
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

    public function total_harga_jual($golongan = null, $kepemilikan = null) : ?int
    {
        if ($golongan != null && $golongan != 'semua') {
            $this->db->where('product_type', $golongan);
        }

        if ($kepemilikan != null && $kepemilikan != 'semua') {
            $this->db->where('ownership', $kepemilikan);
        }

        $result = $this->db->select_sum('selling_price')
            ->get('master_barang')->row();

        return (int) $result->selling_price;
    }

    public function total_harga_beli($golongan = null, $kepemilikan = null) : ?int
    {
        if ($golongan != null && $golongan != 'semua') {
            $this->db->where('product_type', $golongan);
        }

        if ($kepemilikan != null && $kepemilikan != 'semua') {
            $this->db->where('ownership', $kepemilikan);
        }

        $result = $this->db->select_sum('buying_price')
            ->get('master_barang')->row();

        return (int) $result->buying_price;
    }
}
