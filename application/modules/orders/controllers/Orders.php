<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller
{
    private $table = 'orders';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Orders/M_orders');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'orders/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        try {
            // avoid validation
            // validation($data, 'orders', $this->form_validation);

            $this->M_orders->create($data);

            // insert log
            $this->log_model->create('tambah orders');
            
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('orders/index','refresh');
        } catch (Exception $e) {
            $this->create();
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'orders/store';
        $data['action'] = 'add';
        $data['supplier'] = $this->utils_model->list_data_for_select('suppliers');

        $this->template->load('template', 'orders/create_edit', $data);
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
        
        $whereRaw = "orders.created_at >='".$tanggalAwal." 00:00' AND orders.created_at <= '".$tanggalAkhir." 23:59'";

        $this->datatables
            ->select("
                order_number
                , order_date
                , spm
                , tracking_number
                , 'test' as action
            ")
            ->from($this->table)
            ->where($whereRaw);

        if (!isset($input['order'])) {
            $this->datatables->order_by('orders.created_at');
        }

        $this->datatables->edit_column('order_date', '$1', 'ymdTodmy(order_date)');

        echo $this->datatables->generate();
    }

    public function detail($id) {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'orders/store';
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


        $this->template->load('template', 'orders/create_edit', $data);
    }
}
