<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends MY_Controller
{
    private $table = 'backups';

    public function __construct() {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        //$this->load->model('Backup/M_backup');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'backup/index', $data);
    }

    public function download()
    {
				$this->load->dbutil();
				$this->load->helper('file');
				$this->load->helper('download');

				$config = array(
					'format'	=> 'zip',
					'filename'	=> 'database.sql'
				);

				$backup =& $this->dbutil->backup($config);
				$file_name = 'db_apotek.zip';

				$this->load->helper('download');
				force_download($file_name, $backup);
    }
}
