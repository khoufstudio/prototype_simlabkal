<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Arus_kas extends MY_Controller
{
    private $table = "arus_kas";

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Arus_kas/M_arus_kas');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'arus_kas/index', $data);
    }

    public function get_datatables_json()
    {
        $date = $this->input->post('searchDate');

        if ($date) {
            $date = explode(" - ", $date);
            $tanggalAwal = str_replace("/", "-", $date[0]);
            $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
            $tanggalAkhir = str_replace("/", "-", $date[1]);
            $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
            
            $whereRaw = "arus_kas.tanggal BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";
        }

        $this->datatables
            ->select("
              	min(tanggal) as tanggal
                , keterangan
                , sum(jumlah) as jumlah
                , status
            ")
            ->from($this->table)
            ->group_by('keterangan');

            
        if ($date) {
            $this->datatables->where($whereRaw);
        }

        $this->datatables->edit_column('tanggal', '$1', 'ymdHisTodmyHis(tanggal)');
        $this->datatables->edit_column('jumlah', '$1', 'intToRupiah(jumlah)');

        echo $this->datatables->generate();
    }

    public function total_arus_kas() : void
    {
        $date = $this->input->get('tanggal');
        $result = 0;

        if ($date) {
            $date = explode(" - ", $date);
            $tanggal_awal = str_replace("/", "-", $date[0]);
            $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
            $tanggal_akhir = str_replace("/", "-", $date[1]);
            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

            $result = $this->M_arus_kas->total_arus_kas($tanggal_awal, $tanggal_akhir);
        }         

        $result = (int) $result;

        if ($result < 0) {
            echo "-" . intToRupiah(abs($result));
        } else {
            echo intToRupiah($result);
        }
    }
}
