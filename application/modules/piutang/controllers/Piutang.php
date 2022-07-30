<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Piutang extends MY_Controller
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Piutang/M_piutang');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'piutang/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_piutang->create($data);

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('piutang/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        $date = $this->input->post('searchDate');
        $date = explode(" - ", $date);
        $tanggalAwal = str_replace("/", "-", $date[0]);
        $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
        $tanggalAkhir = str_replace("/", "-", $date[1]);
        $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
        
        $whereRaw = "sellings.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";

        $this
            ->datatables
            ->select("
                sellings.selling_code, 
                sellings.total as total, 
                customers.name as customer,
                sellings.created_at AS tanggal_buat,
                concat('<button id=\"credit-', sellings.id, '\" class=\"btn btn-primary credit\">Bayar</button>','<a href=\"".base_url()."piutang/detail/', sellings.id, '\"class=\"btn btn-success\" style=\"display: inline;margin-left: 8px;\">Rincian</a>') as edit_credit,
                cp.rest as credit_rest,
                0 as rest
            ")
            ->from('sellings')
            ->join('customers', 'customers.id = sellings.customer_id')
            ->join('payment_credits cp', 'cp.selling_id = sellings.id', 'left')
            ->where($whereRaw)
            ->where('fully_pay', false) 
            ->where('payment', 'kredit')    
            ->group_by('sellings.id');

        $this->datatables->edit_column('tanggal_buat', '$1', 'ymdHisTodmyHis(tanggal_buat)');
        $this->datatables->edit_column('rest', '$1', 'rest_count(credit_rest, total)');
        $this->datatables->edit_column('total', '$1', 'intToRupiah(total)');

        echo $this->datatables->generate();
    }

    public function get_barang($id_barcode)
    {
        $result = $this->utils_model->listData("master_products", array("product_barcode" => $id_barcode));
        echo json_encode($result);
    }

    public function detail($selling_id)
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['base'] = strtolower(get_class($this));

        $data['payment_credits'] = $this->utils_model->listData("payment_credits", array("selling_id" => $selling_id));
        $data['selling'] = $this->utils_model->getEdit("sellings", array("id" => $selling_id), 'selling_code');

        $this->template->load('template', 'piutang/detail', $data);
    }
}
