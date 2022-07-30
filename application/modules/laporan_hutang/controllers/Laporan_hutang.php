<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_hutang extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Hutang/M_hutang');
        $this->load->model('Laporan_Hutang/M_laporan_hutang');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['supplier'] = $this->utils_model->list_data_for_select("suppliers");
        $semua = array('id' => '', 'name' => 'Semua');
        array_unshift($data['supplier'], $semua);

        $this->template->load('template', 'laporan_hutang/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_laporan_hutang->create($data);

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('laporan_hutang/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        $date = $this->input->post('searchDate');
        $custom_search = $this->input->post('custom_search');
        
        $whereRaw = null;

        if ($date) {
            $date = explode(" - ", $date);
            $tanggalAwal = str_replace("/", "-", $date[0]);
            $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
            $tanggalAkhir = str_replace("/", "-", $date[1]);
            $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
            
            $whereRaw = "purchases.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";
        }

        $this->datatables
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

        if ($whereRaw) {
            $this->datatables->where($whereRaw);
        }

        if (isset($custom_search['supplier'])) {
            $this->datatables->where('suppliers.id', $custom_search['supplier']);
        }

        $this->datatables->edit_column('tanggal_buat', '$1', 'ymdHisTodmyHis(tanggal_buat)');
        $this->datatables->edit_column('rest', '$1', 'rest_count(debt_rest, total)');
        $this->datatables->edit_column('total', '$1', 'intToRupiah(total)');

        echo $this->datatables->generate();
    }

    public function detail($purchase_id)
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['base'] = strtolower(get_class($this));

        $data['payment_debts'] = $this->utils_model->listData("payment_debts", array("purchase_id" => $purchase_id));
        $data['purchase'] = $this->utils_model->getEdit("purchases", array("id" => $purchase_id), 'invoice_number, supplier_id');
        $data['supplier'] = $this->utils_model->getEdit("suppliers", array("id" => $data['purchase']['supplier_id']), 'name');
        // todo

        $this->template->load('template', 'laporan_hutang/detail', $data);
    }

    public function print_laporan_hutang()
    {
        $periode = $this->input->get('periode');
        $periode = str_replace("'", "", $periode);

        $supplier_id = $this->input->get('supplier');
        $data['list_laporan_hutang'] = $this->M_laporan_hutang->laporan_hutang_print($supplier_id, $periode);

        $data['periode'] = $periode;
        $data['supplier'] = $supplier_id;

        $this->load->view('laporan_hutang/print', $data);   
    }
}
