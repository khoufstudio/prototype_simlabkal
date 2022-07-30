<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_stok extends MY_Controller
{
    private $table = 'master_barang';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Data_stok/M_data_stok');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['types'] = $this->utils_model->listData('types', null, 'name as id, name');
        array_unshift($data['types'], 'Semua');

        $this->template->load('template', 'data_stok/index', $data);
    }

    public function print_data_stok()
    {
        $data['kepemilikan'] = $kepemilikan = $this->input->get('kepemilikan');
        $data['golongan'] = $golongan = $this->input->get('golongan');

        $data['harga_jual'] = $this->M_data_stok->total_harga_jual($golongan, $kepemilikan);
        $data['harga_beli'] = $this->M_data_stok->total_harga_beli($golongan, $kepemilikan);

        $filter = array();

        if (isset($data['golongan']) && $data['golongan'] != 'semua') {
            $filter['product_type'] = $data['golongan'];
        }

        if (isset($data['kepemilikan']) && $data['kepemilikan'] != 'semua') {
            $filter['ownership'] = $data['kepemilikan'];
        }

        $data['list_data_stok'] = $this->utils_model->listData($this->table, $filter, 'name, denomination_name, ownership, product_type, stock, buying_price, selling_price');
      
        $this->load->view('data_stok/print', $data);   
    }

    public function get_datatables_json()
    {
        $custom_search = $this->input->post('custom_search');

        $this->datatables
            ->select("
                name
                , denomination_name
                , ownership
                , product_type
                , stock
                , buying_price
                , selling_price
            ")
            ->from($this->table);

        if (isset($custom_search['golongan']) && $custom_search['golongan'] != 'semua') {
            $this->datatables->where('product_type', $custom_search['golongan']);
        }

        if (isset($custom_search['kepemilikan']) && $custom_search['kepemilikan'] != 'semua') {
            $this->datatables->where('ownership', strtolower($custom_search['kepemilikan']));
        }

        $this->datatables->edit_column('buying_price', '$1', 'intToRupiah(buying_price)');
        $this->datatables->edit_column('selling_price', '$1', 'intToRupiah(selling_price)');

        echo $this->datatables->generate();
    }

    public function total_harga()
    {
        $golongan = $this->input->get('golongan');
        $kepemilikan = $this->input->get('kepemilikan');

        $harga_jual = $this->M_data_stok->total_harga_jual($golongan, $kepemilikan);
        $harga_beli = $this->M_data_stok->total_harga_beli($golongan, $kepemilikan);

        $result = array(
            'harga_jual' => intToRupiah($harga_jual),
            'harga_beli' => intToRupiah($harga_beli)
        );

        $this->output
           ->set_content_type('application/json')
           ->set_output(json_encode($result));
    }
}
