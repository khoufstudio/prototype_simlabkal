<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Penjualan extends MY_Controller
{
    private $table = 'sellings';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Penjualan/M_penjualan');
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'penjualan/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        try {
            if (isset($data['print'])) {
                $this->print_struk($data);
            }

            validation($data, 'penjualan', $this->form_validation);
            $result = $this->M_penjualan->create($data);

            if ($result) {
                // insert log
                $this->log_model->create('tambah penjualan');

                $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

                redirect('penjualan/index','refresh');
            }
        } catch (Exception $e) {
            $this->create();
        }
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'penjualan/store';
        $data['action'] = 'add';
        $data['customers'] = $this->utils_model->list_data_for_select('customers');
        $data['selling_code'] = $this->M_penjualan->last_selling_code();
        $data['cashier_name'] = $this->session->userdata('user')->nama;

        $this->template->load('template', 'penjualan/create_edit', $data);
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
        
        $whereRaw = "sellings.created_at BETWEEN '".$tanggalAwal." 00:00' AND '".$tanggalAkhir." 23:59'";

        $this->datatables
            ->select("
                concat('PJ', sellings.selling_code) as selling_code, 
                sellings.payment, 
                sellings.total AS harga_total,
                customers.name as customer,
                DATE_FORMAT(sellings.created_at, '%d/%m/%Y %H:%i') AS tanggal_buat,
                concat('<a href=\"".base_url()."penjualan/detail/', sellings.id, '\"class=\"btn btn-block btn-primary btn-xs\"><i class=\"fa fa-pencil\"></i></a>') as aksi
            ")
            ->from($this->table)
            ->join('customers', 'customers.id = sellings.customer_id')
            ->where($whereRaw);
        
        if (!isset($input['order'])) {
            $this->order_by('sellings.created_at');
        }

        $this->datatables->edit_column('harga_total', '$1', 'intToRupiah(harga_total)');

        echo $this->datatables->generate();
    }

    public function detail($id) {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'pembelian/store';
        $data['action'] = 'add';
        $data['customers'] = $this->utils_model->list_data_for_select('customers');
        $data['sellings'] = $this->utils_model->getEdit('sellings', array('id' => $id));
        $data['selling_code'] = $data['sellings']['selling_code'];       
        $data['cashier_name'] = $this->session->userdata('user')->nama;
        $data['selling_detail'] = $this->M_penjualan->selling_detail($data['sellings']['id']);

        $this->template->load('template', 'penjualan/create_edit', $data);
    }

    public function print_struk($param = [])
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $connector = new WindowsPrintConnector($_ENV['PRINTER_NAME']);
        } else {
            $connector = new FilePrintConnector($_ENV['PRINTER_NAME']);
        }

        $printer = new Printer($connector);
        $tanggal = date('d/m/Y H:s');

        /* Print some bold text */
        $printer->setEmphasis(true);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2,1);
        $printer->text("APOTEK\n");
        $printer->text("SUMBER WARAS\n");
        $printer->setTextSize(1,1);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("--------------------------------\n");
        $printer->text("Tgl: ". $tanggal."\n");
        $printer->text("Kode Pembelian: ". $param["kode_penjualan"]."\n");
        $printer->text("Nama Kasir: ". $param["nama_kasir"]."\n");
        $printer->text("\n");
        foreach ($param["products"] as $product) {
            $product_container = explode("|", $product);
            $printer->text($product_container[4] ." : ". ($product_container[3]). " x " . $product_container[2]."\n");
        }
        $printer->text("Total: ". ($param["jumlah_penjualan"]) ."\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setTextSize(4,4);
        $printer->setTextSize(1,1);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("--------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setTextSize(4,4);

        $printer->setEmphasis(false);
        $printer->feed();

        /* Bar-code at the end */
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->barcode("987654321");
        $printer->cut();

        /* Always close the printer! On some PrintConnectors, no actual
        * data is sent until the printer is closed. */
        $printer->close();
    }
}
