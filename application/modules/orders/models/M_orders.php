<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_orders extends CI_Model
{
    private $table = 'purchases';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
    
    public function create($data) 
    {
    }
}
