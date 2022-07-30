<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_aktivitas extends MY_Controller
{
    private $table = "log_activities";
    private $num = 0;
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form', 'utility_helper');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'log_aktivitas/index', $data);
    }

    public function get_datatables_json()
    {
        $this->datatables
            ->select(" 
                user
                , activity
                , IFNULL(description, '-') as description
                , DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') AS tanggal_buat
            ")                
            ->from($this->table)
            ->order_by('created_at');
        
        echo $this->datatables->generate();
    }

}
