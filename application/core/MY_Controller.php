<?php 
    class MY_Controller extends MX_Controller
    {
        private $validation_rules;

        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');

            $sesi_user = $this->session->userdata('username');
            $controller = $this->uri->segment(1);
            if (($sesi_user == null) 
                && $controller != 'auth' 
                && $controller != 'index' 
                && $controller != "migration"
            ) {
                redirect('/');
            }
        }
    }
    
?>
