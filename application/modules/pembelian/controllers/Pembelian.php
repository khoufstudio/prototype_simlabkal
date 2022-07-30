<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends MY_Controller
{
    private $table = 'purchases';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Pembelian/M_pembelian');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'pembelian/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        try {
            validation($data, 'pembelian', $this->form_validation);

            $result = $this->M_pembelian->create($data);
            // insert log
            // todo: if have changed selling/buying price, add in description
            $this->log_model->create('tambah pembelian');
            
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('pembelian/index','refresh');
        } catch (Exception $e) {
            $this->create();
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'pembelian/store';
        $data['action'] = 'add';
        $data['supplier'] = $this->utils_model->list_data_for_select('suppliers');
        $data['purchase_code'] = $this->M_pembelian->last_purchase_code();

        $this->template->load('template', 'pembelian/create_edit', $data);
    }

    public function get_datatables_json()
    {
        // input post
        $input = $this->input->post();

        $date = $this->input->post('searchDate');
        $date = explode(" - ", $date);
        $tanggalAwal = str_replace("/", "-", $date[0]);
        $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
        $tanggalAkhir = str_replace("/", "-", $date[1]);
        $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
        
        $whereRaw = "purchases.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";

        $this->datatables
            ->select("
                concat('PB', purchases.purchase_code) as purchase_code, 
                purchases.payment, 
                purchases.invoice_number, 
                purchases.total as total_rupiah,
                suppliers.name as supplier,
                purchases.created_at AS tanggal_buat,
                concat('<a href=\"".base_url()."pembelian/detail/', purchases.id, '\"class=\"btn btn-block btn-success btn-xs\" style=\"display: inline;margin-right: 8px;\"><i class=\"fa fa-pencil\"></i></a>') as action
            ")
            ->from($this->table)
            ->join('suppliers', 'suppliers.id = purchases.supplier_id')
            ->where($whereRaw);

        if (!isset($input['order'])) {
            $this->datatables->order_by('purchases.created_at');
        }

        $this->datatables->edit_column('total_rupiah', '$1', 'intToRupiah(total_rupiah)');
        $this->datatables->edit_column('tanggal_buat', '$1', 'ymdHisTodmyHis(tanggal_buat)');

        echo $this->datatables->generate();
    }

    public function detail($id) {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'pembelian/store';
        $data['action'] = 'add';
        $data['supplier'] = $this->utils_model->list_data_for_select('suppliers');
        $data['purchases'] = $this->utils_model->getEdit('purchases', array('id' => $id));
        $data['purchase_code'] = $data['purchases']['purchase_code'];       
        $purchase_detail_param['select'] = 'products.name, purchase_details.*';
        $purchase_detail_param['table'] = 'purchase_details';
        $purchase_detail_param['table_where'] = array('purchase_id' => $data['purchases']['id']);
        $purchase_detail_param['table_detail'] = 'products';
        $purchase_detail_param['on_table'] = 'purchase_details.product_id';
        $purchase_detail_param['on_table_detail'] = 'products.id';

        $data['purchase_detail'] = $this->utils_model->listDataDetail($purchase_detail_param);


        $this->template->load('template', 'pembelian/create_edit', $data);
    }

    // print faktur belum jalan
    public function print_faktur($id) {
        $data['purchases'] = $this->utils_model->getEdit('purchases', array('id' => $id));
        $data['purchase_code'] = $data['purchases']['purchase_code'];       
        $purchase_detail_param['table'] = 'purchase_details';
        $purchase_detail_param['table_where'] = array('purchase_id' => $data['purchases']['id']);
        $purchase_detail_param['table_detail'] = 'products';
        $purchase_detail_param['on_table'] = 'purchase_details.product_id';
        $purchase_detail_param['on_table_detail'] = 'products.id';

        $data['purchase_detail'] = $this->utils_model->listDataDetail($purchase_detail_param);
    }
}
