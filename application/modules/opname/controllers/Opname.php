<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Opname extends MY_Controller
{
    private $table = 'opnames';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Opname/M_opname');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['barang'] = $this->utils_model->listData("products");

        $this->template->load('template', 'opname/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = $this->M_opname->create($data);

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('opname/index','refresh');
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'Opname/store';
        $data['action'] = 'add';


        $this->template->load('template', 'opname/create_edit', $data);
    }

    public function get_datatables_json()
    {
        $date = $this->input->post('searchDate');
        $date = explode(" - ", $date);
        $tanggalAwal = str_replace("/", "-", $date[0]);
        $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
        $tanggalAkhir = str_replace("/", "-", $date[1]);
        $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
        
        $whereRaw = "o.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";
        $this->datatables
            ->select("
                o.stock_current
                , o.stock_real_current
                , o.reason
                , o.created_at
                , p.name as product_name
                , DATE_FORMAT(o.created_at, '%d/%m/%Y %H:%i') AS tanggal_buat,
            ")
            ->from($this->table . ' o')
            ->join('products p', 'o.product_id = p.id')
            ->where($whereRaw);

        echo $this->datatables->generate();
    }

    public function print_opname()
    {
        $data['periode'] = $this->input->post('periode');
        $data['laporan_opname'] = $this->M_opname->laporan_opname();

        $this->load->view('opname/download', $data);   
    }
}
