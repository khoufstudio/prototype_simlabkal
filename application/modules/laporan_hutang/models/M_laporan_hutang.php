<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_laporan_hutang extends CI_Model
{
	private $table = 'card_stocks';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
	
    public function laporan_hutang_print($supplier_id, $periode)
    {
        $date = explode(" - ", $periode);
        $tanggal_awal = str_replace("/", "-", $date[0]);
        $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
        $tanggal_akhir = str_replace("/", "-", $date[1]);
        $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
        $where_periode = "purchases.created_at BETWEEN '".$tanggal_awal." 00:00' AND '".$tanggal_akhir." 23:59'";

        $result = $this->db
            ->select("
                purchases.purchase_code, 
                purchases.invoice_number, 
                purchases.total as total, 
                suppliers.name as supplier,
                purchases.created_at as tanggal_buat,
                concat('<a href=\"".base_url()."laporan_hutang/detail/', purchases.id, '\"class=\"btn btn-block btn-primary\" style=\"display: inline;margin-right: 8px;\">Rincian</a>') as edit_debt,
                min(dp.rest) as debt_rest,
                0 as rest
            ")
            ->from('purchases')
            ->join('suppliers', 'suppliers.id = purchases.supplier_id')
            ->join('payment_debts dp', 'dp.purchase_id = purchases.id', 'left')
            ->where('payment', 'kredit')
            ->group_by('purchases.id');

        if ($where_periode) {
            $this->db->where($where_periode);
        }

        if (isset($supplier_id)) {
            $this->db->where('suppliers.id', $supplier_id);
        }

        return $result->get()->result_array();
    }
    
}
