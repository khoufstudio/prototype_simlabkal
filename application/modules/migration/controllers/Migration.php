<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index()
    {
        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
            echo "Migration table has created";
        }
    }

    public function current()
    {
        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
            echo "Migration table has created";
        }
    }
}
