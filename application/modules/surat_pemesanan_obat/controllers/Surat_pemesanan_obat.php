<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_pemesanan_obat extends MY_Controller
{
    private $table = 'order_medicines';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('surat_pemesanan_obat/M_surat_pemesanan_obat');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'surat_pemesanan_obat/index', $data);
    }

    public function create()
    {

        $data['type_order'] = $this->input->get('type_order');
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'surat_pemesanan_obat/store';
        $suppliers = $this->utils_model->list_data_for_select('suppliers');
        $data['jenis'] = array(array('id' => 0, 'name' => 'Prekursor'), array('id' => 1, 'name' => 'Tertentu'));

        foreach ($suppliers as $supplier) {
            $data['supplier'][] = array('id' => $supplier['name'], 'name' => $supplier['name']);
        }
        $data['action'] = 'add';

        $this->template->load('template', 'surat_pemesanan_obat/create_edit', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        $result = $this->M_surat_pemesanan_obat->create($data);

        if ($result) {
            // insert log
            $this->log_model->create('tambah surat pemesanan obat');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

            redirect('surat_pemesanan/index','refresh');
        }
    }

    public function update($id)
    {
        $data = $this->input->post();
        $result = $this->M_surat_pemesanan_obat->update($id, $data);

        if ($result) {
            // insert log
            $this->log_model->create('update surat pemesanan');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah diupdate');

            redirect('surat_pemesanan/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        $this->datatables
            ->select("
                id, 
                customer_name, 
                DATE_FORMAT(order_date, '%d/%m/%Y') AS order_date,
            ")
            ->add_column('action',
               '<a href="'.base_url().'surat_pemesanan_obat/detail/$1" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></a>
                <form style="display: inline;" action="'.base_url('surat_pemesanan_obat/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger btn-delete" type="submit"  style="display: inline;"><i class="fa fa-trash"></i></button>
                </form>
                <a href="'.base_url('surat_pemesanan_obat/print_surat_pemesanan_obat/$1').'" class="btn btn-xs btn-info btn-print"><i class="fa fa-print"></i></a>
                ', 'id, name'
            )
            ->from($this->table)
            ->order_by('created_at');

        echo $this->datatables->generate();
    }

    public function detail($id)
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'surat_pemesanan_obat/store';
        $data['action'] = 'add';
        $data['jenis'] = array(array('id' => 0, 'name' => 'Prekursor'), array('id' => 1, 'name' => 'Tertentu'));
        $suppliers = $this->utils_model->list_data_for_select('suppliers');
        foreach ($suppliers as $supplier) {
            $data['supplier'][] = array('id' => $supplier['name'], 'name' => $supplier['name']);
        }
        $data['orders'] = $this->utils_model->getEdit('order_medicines', array('id' => $id));
        $order_detail_param['select'] = 'products.name, order_medicine_details.*';
        $order_detail_param['table'] = 'order_medicine_details';
        $order_detail_param['table_where'] = array('order_id' => $data['orders']['id']);
        $order_detail_param['table_detail'] = 'products';
        $order_detail_param['on_table'] = 'order_medicine_details.product_id';
        $order_detail_param['on_table_detail'] = 'products.id';

        $data['order_detail'] = $this->utils_model->listDataDetail($order_detail_param);

        $this->template->load('template', 'surat_pemesanan_obat/create_edit', $data);
    }

    public function delete($id)
    {
        $nama_surat_pemesanan_obat = $this->input->post('name');

        $this->db->trans_start();
        $data = $this->utils_model->delete('orders', array('id' => $id));
        $this->db->trans_complete();


        if ($data) {
            // insert log
            $this->log_model->create('delete surat pemesanan');

            $form_message = 'Data '.$nama_surat_pemesanan_obat.' telah dihapus';
            $form_success = true;
        } else {
            $form_message = 'Data '.$nama_surat_pemesanan_obat.' gagal dihapus, karena telah digunakan';
            $form_success = false;
        }

        $this->session->set_flashdata(
            array(
                'form_success' =>  $form_success, 
                'form_message' =>  $form_message
            )
        );

        redirect('surat_pemesanan_obat/index','refresh');
    }

    
    public function print_surat_pemesanan_obat($id)
    {
        $data['kop'] = $this->utils_model->getEdit('letterheads', null, 'content')['content'];
        $data['order'] = $this->utils_model->getEdit('order_medicines', array('id' => $id));
        $data['order_details'] = $this->M_surat_pemesanan_obat->order_detail($id);

        $this->load->view('surat_pemesanan_obat/print', $data);
    }
}
