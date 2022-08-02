<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;

class Calibrations extends MY_Controller
{
    private $table = 'orders';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('calibrations/M_calibrations');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'calibrations/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        try {
            // avoid validation
            // validation($data, 'calibrations', $this->form_validation);

            $this->M_calibrations->create($data);

            // insert log
            $this->log_model->create('tambah calibrations');
            
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('calibrations/index','refresh');
        } catch (Exception $e) {
            $this->create();
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'calibrations/store';
        $data['action'] = 'add';

        $this->template->load('template', 'calibrations/create_edit', $data);
    }

    public function edit($id)
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'calibrations/store';
        $select = "id, order_number, spm, order_date, owner, address, contact_person";
        $data['data'] = $this->utils_model->getEdit("orders", array("id" => $id), $select);
        $data['action'] = 'update';
        $data['calibrations'] = $this->utils_model->listData('calibrations',
            array('order_id' => $id),
            'subject, brand, calibration_officer, calibration_completion_date, description, typist'
        );

        $this->template->load('template', 'calibrations/create_edit', $data);
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
                id
                , order_number
                , order_date
                , spm
                , tracking_number
                , 'test' as action
            ")
            ->from($this->table)
            ->where('tracking_number', 2)
            ->where($whereRaw);

        if (!isset($input['order'])) {
            $this->datatables->order_by('orders.created_at');
        }

        $this->datatables->edit_column('order_date', '$1', 'ymdTodmy(order_date)');
        $this->datatables->edit_column('tracking_number', '$1', 'status_order(tracking_number)');
        $this->datatables->edit_column('spm', '$1', 'spm(spm)');
        $this->datatables->edit_column('action', '$1', 'button_aksi_kalibrasi(id)');

        echo $this->datatables->generate();
    }
}
