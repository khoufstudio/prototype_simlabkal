<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/* End of file Dashboard.php */

class Dashboard extends MY_Controller 
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function index()
    {
        $data['test'] = 0;
        $this->template->load('template', 'dashboard/index', $data);
    }
    
}


?>