<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_pembelian extends MY_Controller
{
    private $table = 'purchase_returns';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Retur_pembelian/M_retur_pembelian');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'retur_pembelian/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_retur_pembelian->create($data);

        if ($result) {
            // insert log
            $this->log_model->create('tambah retur pembelian');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('retur_pembelian/index','refresh');
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'Retur_pembelian/store';
        $data['action'] = 'add';
        $data['supplier'] = $this->utils_model->list_data_for_select("suppliers");

        $this->template->load('template', 'retur_pembelian/create_edit', $data);
    }

    public function get_datatables_purchase_detail_json()
    {
        $supplier = $this->input->post('custom_search')['supplier'] ?? null;
        $no_faktur = $this->input->post('custom_search')['no_faktur'] ?? null;
        $no_batch = $this->input->post('custom_search')['no_batch'] ?? null;
        $input = $this->input->post();

        $this->datatables
            ->select("
                p2.created_at as tanggal_beli
                , p2.invoice_number
                , p3.name as product_name
                , s2.name as supplier_name
                , p2.due_date
                , pd.batch_number
                , pd.current_stock
                , pd.price
                , concat('<button id=\'', pd.id, '\' class=\'btn btn-warning button-retur btn-sm\'><i class=\'fa fa-refresh\' style=\'margin-right: 10px;\'></i> Retur</button>') AS button
            ")
            ->from('purchase_details pd')
            ->join('purchases p2', 'pd.purchase_id = p2.id') 
            ->join("products p3", 'p3.id = pd.product_id')
            ->join("suppliers s2", 's2.id = p2.supplier_id')
            ->where('pd.quantity <>', 0)
            ->where('pd.current_stock <>', 0);

        $this->datatables->edit_column('price', '$1', 'intToRupiah(price)');
        $this->datatables->edit_column('tanggal_beli', '$1', 'ymdHisTodmyHis(tanggal_beli)');
        $this->datatables->edit_column('due_date', '$1', 'ymdtoDmy(due_date)');

        if ($supplier) {
            $this->datatables->where('s2.id', $supplier);
        }

        if ($no_batch) {
            $this->datatables->where('pd.batch_number', $no_batch);
        }

        if ($no_faktur) {
            $this->datatables->where('p2.invoice_number', $no_faktur);
        }

        if (!isset($input['order'])) {
            $this->datatables->order_by('pd.created_at');
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

            $where_raw = "pd.updated_at BETWEEN '".$tanggal_awal." 00:00' AND '".$tanggal_akhir." 23:59'";
        }
        
        $this->datatables
            // purchase & supplier
            ->select("
                pr.id
                , concat('RB', pr.purchase_return_code) as purchase_return_code
                , pr.created_at AS tanggal_beli
                , s.name as supplier_name 
                , p2.name as product_name
                , pd.batch_number
                , pr.quantity
                , pd.price
            ")
            ->from('purchase_returns pr')
            ->join("purchase_details pd", 'pd.id = pr.purchase_detail_id')
            ->join('purchases p', 'p.id = pd.purchase_id')
            ->join('suppliers s', 's.id = p.supplier_id')
            ->join("products p2", 'p2.id = pd.product_id');
            //->where('pd.purchase_return', 1);

        $this->datatables->edit_column('price', '$1', 'intToRupiah(price)');
        $this->datatables->edit_column('tanggal_beli', '$1', 'ymdHisTodmyHis(tanggal_beli)');

        if ($where_raw) {
            $this->datatables->where($where_raw);
        }

        echo $this->datatables->generate();
    }
}
