<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_piutang extends CI_Model
{
	private $table = 'payment_credits';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function create($data)
    {
        $rest = $this->utils_model->get_last_value($this->table, 'rest', 'desc', array("selling_id" => $data['selling_id']), 'created_at');

        if (!$rest) {
            $rest = $this->utils_model->get_last_value('sellings', 'total', 'desc', array("id" => $data['selling_id']));
        }
        $data_insert['selling_id'] = $data['selling_id'];
        $data_insert['installment'] = $data['installment'];
        $data_insert['rest'] = $rest - $data['installment'];

		if ($data_insert['rest'] == 0) {
			$db_where['id'] = $data['selling_id'];
			$data_update['fully_pay'] = true;
			$this->utils_model->update('sellings', $db_where, $data_update);
		}
        
		return $this->utils_model->insert($this->table, $data_insert);
    }
}
 
