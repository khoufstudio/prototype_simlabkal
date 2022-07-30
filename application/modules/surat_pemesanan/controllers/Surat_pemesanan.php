<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_pemesanan extends MY_Controller
{
    private $table = 'orders';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('surat_pemesanan/M_surat_pemesanan');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'surat_pemesanan/index', $data);
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'surat_pemesanan/store';
        $suppliers = $this->utils_model->list_data_for_select('suppliers');

        foreach ($suppliers as $supplier) {
            $data['supplier'][] = array('id' => $supplier['name'], 'name' => $supplier['name']);
        }
        $data['action'] = 'add';

        $this->template->load('template', 'surat_pemesanan/create_edit', $data);
    }

    public function store()
    {
        $result = $this->M_surat_pemesanan->create();

        if ($result) {
            // insert log
            $this->log_model->create('tambah surat pemesanan');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

            redirect('surat_pemesanan/index','refresh');
        }
    }

    public function update($id)
    {
        $data = $this->input->post();
        $result = $this->M_surat_pemesanan->update($id, $data);

        if ($result) {
            // insert log
            $this->log_model->create('update supplier');

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
                jenis_surat,
                order_date,
                link
            ")
            ->add_column('action',
               '<a href="'.base_url().'$3/detail/$1" class="btn btn-xs btn-primary"><i class="fa fa-search"></i></a>
                <form style="display: inline;" action="'.base_url('$3/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger btn-delete" type="submit"  style="display: inline;"><i class="fa fa-trash"></i></button>
                </form>
                <a href="'.base_url('$3/print_$3/$1').'" class="btn btn-xs btn-info btn-print"><i class="fa fa-print"></i></a>
                ', 'id, name, link'
            )
            ->from('surat_pemesanan');


        $this->datatables->edit_column('order_date', '$1', 'ymdtoDmy(order_date)');

        echo $this->datatables->generate();
    }

    public function detail($id)
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'surat_pemesanan/store';
        $data['action'] = 'add';
        $data['orders'] = $this->utils_model->getEdit('orders', array('id' => $id));
        $order_detail_param['select'] = 'products.name, order_details.*';
        $order_detail_param['table'] = 'order_details';
        $order_detail_param['table_where'] = array('order_id' => $data['orders']['id']);
        $order_detail_param['table_detail'] = 'products';
        $order_detail_param['on_table'] = 'order_details.product_id';
        $order_detail_param['on_table_detail'] = 'products.id';

        $data['order_detail'] = $this->utils_model->listDataDetail($order_detail_param);


        $this->template->load('template', 'surat_pemesanan/create_edit', $data);
    }

    public function delete($id)
    {
        $nama_surat_pemesanan = $this->input->post('name');

        $this->db->trans_start();
        $data = $this->utils_model->delete('orders', array('id' => $id));
        $this->db->trans_complete();


        if ($data) {
            // insert log
            $this->log_model->create('delete surat pemesanan');

            $form_message = 'Data '.$nama_surat_pemesanan.' telah dihapus';
            $form_success = true;
        } else {
            $form_message = 'Data '.$nama_surat_pemesanan.' gagal dihapus, karena telah digunakan';
            $form_success = false;
        }

        $this->session->set_flashdata(
            array(
                'form_success' =>  $form_success, 
                'form_message' =>  $form_message
            )
        );

        redirect('surat_pemesanan/index','refresh');
    }

    
    public function print_surat_pemesanan($id)
    {
        $data['kop'] = $this->utils_model->getEdit('letterheads', null, 'content')['content'];
        $data['order'] = $this->utils_model->getEdit('orders', array('id' => $id));
        $data['order_details'] = $this->M_surat_pemesanan->order_detail($id);        

        $this->load->view('surat_pemesanan/print', $data);   
    }
}
