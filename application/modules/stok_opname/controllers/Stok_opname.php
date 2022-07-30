<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_opname extends MY_Controller
{
    private $table = 'opnames';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Stok_opname/M_stok_opname');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['types'] = $this->utils_model->listData('types', null, 'id, name');

        $this->template->load('template', 'stok_opname/index', $data);
    }

    public function get_datatables_json()
    {
        $custom_search = $this->input->post('custom_search');

        $this->datatables
            ->select("
                p.created_at
                , t.name as type_name
                , p.name as product_name
                , p.stock
                , p.expired_date
                , 0 as empty
            ")
            ->from('products p')
            ->join('types t', 't.id = p.type');

        if (isset($custom_search['golongan'])) {
            $this->datatables->where('t.id', $custom_search['golongan']);
        }

        $this->datatables->edit_column('expired_date', '$1', 'ymdtoDmy(expired_date)');

        echo $this->datatables->generate();
    }

    public function print_stok_opname()
    {
        $input_get = $this->input->get();

        if ($golongan = $input_get['golongan']) {
            $data['laporan_stok_opname'] = $this->M_stok_opname->laporan_stok_opname($golongan);
        } else {
            $data['laporan_stok_opname'] = $this->M_stok_opname->laporan_stok_opname();
        }

        $this->load->view('stok_opname/download', $data);   
    }
}
