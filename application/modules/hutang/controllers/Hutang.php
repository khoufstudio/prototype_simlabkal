<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Hutang extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Hutang/M_hutang');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'hutang/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_hutang->create($data);

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('hutang/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        $date = $this->input->post('searchDate');

        if (!is_null($date)) {
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
                concat('<button id=\"debt-', purchases.id, '\" class=\"btn btn-success debt\" style=\"display: inline;margin-right: 8px;\">Bayar</button>') as edit_debt,
                0 as rest,
                dp.rest as debt_rest
            ")
            ->from('purchases')
            ->join('suppliers', 'suppliers.id = purchases.supplier_id')
            ->join('payment_debts dp', 'dp.purchase_id = purchases.id', 'left')
            ->where('payment', 'kredit')
            ->where('fully_pay', false)
            ->group_by('purchases.id, dp.purchase_id');

        if (!is_null($date)) {
            $this->datatables->where($whereRaw);
        }
        $this->datatables->edit_column('tanggal_buat', '$1', 'ymdHisTodmyHis(tanggal_buat)');
        $this->datatables->edit_column('rest', '$1', 'rest_count(debt_rest, total)');
        $this->datatables->edit_column('total', '$1', 'intToRupiah(total)');

        echo $this->datatables->generate();
    }

    public function get_barang($id_barcode)
    {
        $result = $this->utils_model->listData("products", array("product_barcode" => $id_barcode));

        echo json_encode($result);
    }

    public function detail($purchase_id)
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['base'] = strtolower(get_class($this));

        $data['payment_debts'] = $this->utils_model->listData("payment_debts", array("purchase_id" => $purchase_id));
        $data['purchase'] = $this->utils_model->getEdit("purchases", array("id" => $purchase_id), 'invoice_number');

        $this->template->load('template', 'hutang/detail', $data);
    }

}
