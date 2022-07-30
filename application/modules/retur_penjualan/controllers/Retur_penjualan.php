<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_penjualan extends MY_Controller
{
    private $table = 'selling_return';

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Retur_penjualan/M_retur_penjualan');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'retur_penjualan/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_retur_penjualan->create($data);

        if ($result) {
            // insert log
            $this->log_model->create('tambah retur penjualan');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

            redirect('retur_penjualan/index','refresh');
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'Retur_penjualan/store';
        $data['action'] = 'add';
        $data['customer'] = $this->utils_model->list_data_for_select("customers");

        $this->template->load('template', 'retur_penjualan/create_edit', $data);
    }

    public function get_datatables_selling_detail_json()
    {
        $customer = $this->input->post('custom_search')['customer'] ?? null;
        $no_batch = $this->input->post('custom_search')['no_faktur'] ?? null;

        $this->datatables
            ->select("
                sd.id
                , DATE_FORMAT(sd.updated_at, '%d/%m/%Y %H:%i') AS tanggal_beli
                , c.name as nama_customer,
                , p.name as nama_barang
                , sd.batch_number as no_batch
                , (sd.quantity - sd.return_quantity) as kuantiti
                , concat('Rp. ', sd.price) AS harga
                , concat('<button id=\'', sd.id, '\' class=\'btn btn-warning button-retur btn-sm\'><i class=\'fa fa-refresh\' style=\'margin-right: 10px;\'></i> Retur</button>') AS button
            ")
            ->from('selling_details sd')
            ->join("sellings s", 's.id = sd.selling_id')
            ->join("customers c", 'c.id = s.customer_id')
            ->join("products p", 'p.id = sd.product_id')
            ->where('(sd.quantity - sd.return_quantity) <>', 0);

        if ($customer) {
            $this->datatables->where('s.customer_id', $customer);
        }

        if ($no_batch) {
            $this->datatables->where('sd.batch_number', $no_batch);
        }

        echo $this->datatables->generate();
    }
    
    public function get_datatables_json()
    {
        $custom_search = $this->input->post('custom_search');

        if ($custom_search['tanggal_retur']) {
            $date = explode(" - ", $custom_search['tanggal_retur']);
            $tanggal_awal = str_replace("/", "-", $date[0]);
            $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
            $tanggal_akhir = str_replace("/", "-", $date[1]);
            $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
              
            $where_raw = "sd.updated_at BETWEEN '".$tanggal_awal." 00:00:00' AND '".$tanggal_akhir." 23:59:59'";
        }
                
        $this->datatables
            ->select("
                sd.id
                , concat('RJ', sr.selling_return_code) as selling_return_code
                , DATE_FORMAT(sr.updated_at, '%d/%m/%Y %H:%i') AS tanggal_jual
                , c.name as nama_customer
                , mp.name as nama_barang
                , sd.batch_number as no_batch
                , sr.quantity as kuantiti
                , sd.price AS harga
            ")
            ->from('selling_details sd')
            ->join("sellings s", 's.id = sd.selling_id')
            ->join("customers c", 'c.id = s.customer_id')
            ->join("products mp", 'mp.id = sd.product_id')
            ->join("selling_returns sr", 'sr.selling_detail_id = sd.id')
            ->where($where_raw)
            ->where('sd.selling_return', 1);

        $this->datatables->edit_column('harga', '$1', 'intToRupiah(harga)');

        echo $this->datatables->generate();
    }
}
