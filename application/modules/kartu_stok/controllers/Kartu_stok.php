<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu_stok extends MY_Controller
{
    private $table = 'card_stocks';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Kartu_stok/M_kartu_stok');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['barang'] = $this->utils_model->listData("products");

        $this->template->load('template', 'kartu_stok/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_kartu_stok->create($data);

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('kartu_stok/index','refresh');
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'Kartu_stok/store';
        $data['action'] = 'add';


        $this->template->load('template', 'kartu_stok/create_edit', $data);
    }

    public function print_kartu_stok()
    {
        $product_id = $this->input->get('product_id');
        $periode = $this->input->get('periode');
        $periode = str_replace("'", "", $periode);

        $product = $this->utils_model->getEdit("products", array("id" => $product_id), 'name');

        $data['nama_barang'] = $product['name'];
        $data['periode'] = $periode;
        $data['list_kartu_stok'] = $this->M_kartu_stok->kartu_stok_print($product_id, $periode);
      
        $this->load->view('kartu_stok/print', $data);   
    }

    public function get_datatables_json()
    {
        // input post
        $input = $this->input->post();

        $product_id = $this->input->post('custom_search')['product_id'];
        $periode = $this->input->post('custom_search')['periode'];

        $date = explode(" - ", $periode);
        $tanggal_awal = str_replace("/", "-", $date[0]);
        $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
        $tanggal_akhir = str_replace("/", "-", $date[1]);
        $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));
        $where_periode = "created_at BETWEEN '".$tanggal_awal." 00:00' AND '".$tanggal_akhir." 23:59'";

        $this->datatables
            ->select("created_at, transaction_code, supplier_name, quantity, stock, expired_date")
            ->from($this->table)
            ->where($where_periode);

        if (!isset($input['order'])) {
            $this->datatables->order_by('created_at');
        }
        $this->datatables->edit_column('created_at', '$1', 'ymdHisTodmyHis(created_at)');
        $this->datatables->edit_column('expired_date', '$1', 'ymdtoDmy(expired_date)');

        if ($product_id) {
            $this->datatables->where('product_id', $product_id);
        }

        echo $this->datatables->generate();
    }
}
