<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_golongan extends MY_Controller
{
    private $table = 'types';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Master_golongan/M_master_golongan');
        $this->load->library('datatables');
        $this->load->library('form_validation');

        $this->validation_rules = $this->M_master_golongan->get_validation_rules();
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'master_golongan/index', $data);
    }

    public function store()
    {
        $data = $this->input->post();
        $result = new StdClass();

        try {
            // validation
            validation($data, $this->validation_rules, $this->form_validation);

            // insert to db
            $this->M_master_golongan->create($data);

            // insert log
            $this->log_model->create('tambah golongan');

            $result->success = true;
            $result->message = "sukses ditambah";
        } catch (Exception $e) {
            $result->success = false;
            $result->message = $e->getMessage();        
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function update($id)
    {
        $data = $this->input->post();
        $result = new StdClass();
        $current_data = $this->utils_model->getEdit($this->table, array("id" => $id), 'name');
        $validation_rules = $this->validation_rules;

        if ($current_data['name'] == $data['nama']) {
            $validation_rules[0]['rules'] = 'required';
        }

        try {
            // validation
            validation($data, $validation_rules, $this->form_validation);

            $this->M_master_golongan->update($id, $data);

            // insert log
            $this->log_model->create('update golongan');

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

    public function get_datatables_json()
    {
        $this->datatables
            ->select("id, name")
            ->add_column('action',
               '<a href="'.base_url().'master_golongan/edit/$1" class="btn btn-xs btn-primary item-edit"><i class="fa fa-edit"></i></a>
                <form style="display: inline;" action="'.base_url('master_golongan/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger btn-delete" type="submit"  style="display: inline;"><i class="fa fa-trash"></i></button>
                </form>', 'id, name'
            )
            ->from($this->table)
            ->order_by('created_at');

        echo $this->datatables->generate();
    }

    public function golongan()
    {
        $name = $this->input->get('name');
        $select = $this->input->get('select');

        if (!isset($select)) {
            $select = "*";
        }

        if (isset($size)) {
            $result = $this->utils_model->listData("types", array("size" => $size), $select);
        }

        echo json_encode($result);
    }
    
    public function edit($id)
    {
        $select = "id, name";
        $result = $this->utils_model->getEdit("types", array("id" => $id), $select);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function delete($id)
    {
        $nama_master_golongan = $this->input->post('name');

        $this->db->trans_start();
        // find data 
        $products = $this->utils_model->getEdit('products', 'type = "' . $id . '"');

        if (!is_null($products)) {
            $data = false;
        } else {
            $data = $this->utils_model->delete('types', array('id' => $id));
        }

        if ($data) {
            // insert log
            $this->log_model->create('delete golongan');

            $form_message = 'Data '.$nama_master_golongan.' telah dihapus';
            $form_success = true;
        } else {
            $form_message = 'Data '.$nama_master_golongan.' gagal dihapus, karena telah digunakan';
            $form_success = false;
        }
        $this->db->trans_complete();

        $this->session->set_flashdata(
            array(
                'form_success' =>  $form_success, 
                'form_message' =>  $form_message
            )
        );

        redirect('master_golongan/index','refresh');
    }
}