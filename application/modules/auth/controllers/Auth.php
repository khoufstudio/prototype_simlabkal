<?php

class Auth extends MY_Controller
{

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library(array('authuser', 'form_validation'));
        $this->load->model('menus/M_menus');
    }

    public function index() {
        if ($this->authuser->isLogged()) {
            redirect('dashboard');
        }
        
        $data ['warning_message'] = $this->session->flashdata('warning_message');
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->input->post () && $this->form_validation->run () == TRUE) {
            $password_admin = $this->input->post('password');
        
            $username = $this->input->post('username');
            $password = html_entity_decode ( $password_admin, ENT_QUOTES, 'UTF-8' );
            $data ['warning_message'] = $this->authuser->login($username, $password);
            
            if ($data ['warning_message'] === null) {
                // insert log
                $this->log_model->create('login');

                redirect ('dashboard');
            }
        }  
    
        $this->load->view('v_login', $data);
    }

    public function logout()
    {
        // insert log
        $this->log_model->create('logout');

        $this->authuser->logout();

        redirect('auth');
    }
}
