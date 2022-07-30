<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laba_rugi extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Laba_rugi/M_laba_rugi');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'laba_rugi/index', $data);
    }

    public function find()
    {
        $data = $this->input->get('tanggal');

        $tanggal_temp = explode("-", $data);
        $tanggal_awal = dmyToymd($tanggal_temp[0], "-") . ' 00:00:00';
        $tanggal_akhir = dmyToymd($tanggal_temp[1], "-") . ' 23:59:59';

        $total_penjualan = $this->M_laba_rugi->total_penjualan($tanggal_awal, $tanggal_akhir);
        $total_pembelian = $this->M_laba_rugi->total_pembelian($tanggal_awal, $tanggal_akhir);
        $total_pengeluaran = $this->M_laba_rugi->total_pengeluaran_operasional($tanggal_awal, $tanggal_akhir);        
        $total_pemasukan = $this->M_laba_rugi->total_pemasukan_operasional($tanggal_awal, $tanggal_akhir);        
        $total_retur_penjualan = $this->M_laba_rugi->total_retur_penjualan($tanggal_awal, $tanggal_akhir);
        $total_harga_penjualan = $total_penjualan - $total_pembelian - $total_retur_penjualan;
        $total_sementara = $total_harga_penjualan - $total_pengeluaran;
        $total_laba_rugi = $total_penjualan - $total_pembelian - $total_retur_penjualan - $total_pengeluaran + $total_pemasukan;

        $total_penjualan = intToRupiah($total_penjualan);
        $total_pembelian = intToRupiah($total_pembelian);
        $total_retur_penjualan = intToRupiah($total_retur_penjualan);
        $total_harga_penjualan = intToRupiah($total_harga_penjualan);
        $total_pengeluaran = intToRupiah($total_pengeluaran);
        $total_pemasukan = intToRupiah($total_pemasukan);
        $total_sementara = intToRupiah($total_sementara);
        $total_laba_rugi = intToRupiah($total_laba_rugi);

        $result = array(
            'total_penjualan' => $total_penjualan,
            'total_pembelian' => $total_pembelian,
            'total_retur_penjualan' => $total_retur_penjualan,
            'total_sementara' => $total_sementara,
            'total_pengeluaran' => $total_pengeluaran,
            'total_pemasukan' => $total_pemasukan,
            'total_sementara' => $total_sementara,
            'total_harga_penjualan' => $total_harga_penjualan,
            'total_laba_rugi' => $total_laba_rugi
        );

        $this->output
            ->set_output(json_encode($result));
    }
}
