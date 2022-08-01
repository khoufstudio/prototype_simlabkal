<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use Dompdf\Dompdf;

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
        $data['action'] = 'Tambah';
        $data['id'] = date('Ym'). strtoupper(substr(md5(microtime()),rand(0,26),3));

        $this->template->load('template', 'orders/create_edit', $data);
    }
    
    public function edit($id)
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = "orders/update/$id";
        $data['action'] = 'Edit';
        $data['data'] = $this->utils_model->getEdit('orders', array('id' => $id));

        if ($data['data'] === null) {
            echo "data tidak ditemukan";
            return;
        }

        $data['id'] = $data['data']['order_number'];

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
                id
                , order_number
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
        $this->datatables->edit_column('tracking_number', '$1', 'status_order(tracking_number)');
        $this->datatables->edit_column('spm', '$1', 'spm(spm)');
        $this->datatables->edit_column('action', '$1', 'button_aksi_pemesanan(id)');

        echo $this->datatables->generate();
    }

    public function pdf($id)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $data['data_order'] = $this->utils_model->getEdit($this->table, array('id' => $id));
        $this->load->view('orders/pdf.php', $data);

        $order_number = $data['data_order']['order_number'];
        $html = $this->output->get_output();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("Konfirmasi $order_number.pdf", array("Attachment" => 1));
    }

    public function update($id)
    {
        $data = $this->input->post();
        $result = new StdClass();
        
        try {
            // validation
            // validation($data, $validation_rules, $this->form_validation);

            $this->M_orders->update($id, $data);

            // insert log
            $this->log_model->create('update orders');

            $result->message = "sukses diupdate";
            $result->success = true;
        } catch (Exception $e) {
            $result->success = false;
            $result->message = $e->getMessage();        
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
