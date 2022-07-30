<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_arus_kas extends CI_Model
{
    private $table = "arus_kas";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function total_arus_kas($tanggal_awal, $tanggal_akhir) : string
    {
        $pemasukan = $this->total_arus_kas_detail($tanggal_awal, $tanggal_akhir, "pemasukan");
        $pengeluaran = $this->total_arus_kas_detail($tanggal_awal, $tanggal_akhir, "pengeluaran");

        $total_pemasukan = $pemasukan->jumlah;
        $total_pengeluaran = $pengeluaran->jumlah;

        $total = $total_pemasukan - $total_pengeluaran;

        return $total;
    }

    public function total_arus_kas_detail($tanggal_awal, $tanggal_akhir, $tipe)
    {
        $this->db->select_sum('jumlah')
            ->from($this->table)
            ->where('status', $tipe)
            ->where("(tanggal > '$tanggal_awal' and tanggal < '$tanggal_akhir')");

        $result = $this->db->get()->row();

        return $result;
    }
}
