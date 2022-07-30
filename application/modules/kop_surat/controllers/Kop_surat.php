<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kop_surat extends MY_Controller
{
    private $table = 'finances';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Kop_surat/M_kop_surat');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');
        $data['username'] = ucfirst($this->session->username);
        $data['id_kop'] = $id_kop = '23dfd';
        $data['content'] = $this->utils_model->getEdit('letterheads', array('id' => $id_kop), 'content')['content'];

        $this->template->load('template', 'kop_surat/index', $data);
    }


    public function update($id)
    {
        $data = $this->input->post();
        $result = $this->M_kop_surat->update($id, $data);

        if ($result) {
            // insert log
            $this->log_model->create('update kop surat');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah diupdate');

            redirect('kop_surat/index','refresh');
        }
    }
}
