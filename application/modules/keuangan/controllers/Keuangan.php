<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends MY_Controller
{
    private $table = 'finances';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Keuangan/M_keuangan');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');
        $data['username'] = ucfirst($this->session->username);
        $data['transaction'] = array();

        $this->template->load('template', 'keuangan/index', $data);
    }

    public function store()
    {
        // validation
        $validation = $this->validation($this->input->post());

        if ($validation->success) {
            $result = $this->M_keuangan->create();

            if ($result) {
                // insert log
                $this->log_model->create('tambah supplier');
            }
        } 

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($validation));
    }

    public function update($id)
    {
        $data = $this->input->post();
        $result = $this->M_keuangan->update($id, $data);

        if ($result) {
            // insert log
            $this->log_model->create('update supplier');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah diupdate');

            redirect('keuangan/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        //$input_search = $this->input->post()['search']['value'];
        //$input_search = strtolower($input_search);

        $this->datatables
            ->select(
                "id
                , created_at
                , name_income_expense
                , finance_type
                , total
                , description
            ")
            ->from($this->table);

        $this->datatables->edit_column('total', '$1', 'intToRupiah(total)');
        $this->datatables->edit_column('created_at', '$1', 'ymdHisTodmyHis(created_at)');

        echo $this->datatables->generate();
    }

    private function validation($data)
    {
        $validation = new StdClass();
        $validation->success = true;
        $validation->message = array();

        $form_validation = $this->form_validation;
        $form_validation->set_data($data);

        if ($form_validation->run('keuangan') == FALSE) {
            $messageRaw = explode("\n", strip_tags(validation_errors()));
            array_pop($messageRaw);

            $validation->success = false;
            $validation->message = $messageRaw;
        }

        return $validation;
    }
}
