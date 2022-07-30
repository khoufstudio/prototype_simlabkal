<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_laba_rugi extends CI_Model
{
    private $table = 'opnames';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
    
    public function total_pembelian($tanggal_awal, $tanggal_akhir) : int
    {
        $result = $this->db->select_sum('s.total_buying')
            ->from('sellings s')
            ->where('s.fully_pay', 1)
            ->where("(s.updated_at > '$tanggal_awal' and s.updated_at < '$tanggal_akhir')");

        $result = $this->db->get()->result();

        return $result[0]->total_buying ?? 0;
    }

    public function total_penjualan($tanggal_awal, $tanggal_akhir) : int
    {
        $result = $this->db->select_sum('s.total')
            ->from('sellings s')
            ->where('s.fully_pay', 1)
            ->where("(s.updated_at > '$tanggal_awal' and s.updated_at < '$tanggal_akhir')");

        $result = $this->db->get()->result();

        return $result[0]->total ?? 0;
    }

    public function total_retur_penjualan($tanggal_awal, $tanggal_akhir) : int
    {
        $result = $this->db->select_sum('(sr.price * sr.quantity)')
            ->from('selling_returns sr')
            ->where("(sr.created_at > '$tanggal_awal' and sr.created_at < '$tanggal_akhir')");

        $result = $this->db->get()->row_array();

        return $result['quantity)'] ?? 0;
    }

    
    public function total_pengeluaran_operasional($tanggal_awal, $tanggal_akhir) : int
    {
        $result = $this->db->select_sum('total')
            ->from('finances f')
            ->where('finance_type', 'expense')
            ->where("(f.created_at > '$tanggal_awal' and f.created_at < '$tanggal_akhir')");

        $result = $this->db->get()->row();

        return $result->total ?? 0;
    }

    public function total_pemasukan_operasional($tanggal_awal, $tanggal_akhir) : int
    {
        $result = $this->db->select_sum('total')
            ->from('finances f')
            ->where('finance_type', 'income')
            ->where("(f.created_at > '$tanggal_awal' and f.created_at < '$tanggal_akhir')");

        $result = $this->db->get()->row();

        return $result->total ?? 0;
    }

    public function total_pengeluaran($tanggal_awal, $tanggal_akhir) : int
    {
        $total_pengeluaran = $this->total_pengeluaran_operasional($tanggal_awal, $tanggal_akhir);
        $total_pemasukan = $this->total_pemasukan_operasional($tanggal_awal, $tanggal_akhir);

        return $total_pemasukan - $total_pengeluaran;
    }
}
