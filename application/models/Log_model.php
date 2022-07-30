<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model
{
    private $table = 'log_activities';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function create($activity, $description = null)
    {
        $data['user'] = $this->session->username;
        $data['activity'] = $activity;
        $data['description'] = $description;

        return $this->utils_model->insert($this->table, $data);
    }
}


/* End of file Utils_model.php */
 ?>
