<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_hutang extends CI_Model
{
    private $table = 'payment_debts';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function create($data)
    {
        $rest = $this->utils_model->get_last_value($this->table, 'rest', 'desc', array("purchase_id" => $data['purchase_id']), 'created_at');

        if (!$rest) {
            $rest = $this->utils_model->get_last_value('purchases', 'total', 'desc', array("id" => $data['purchase_id']));
        }

        $data_insert['purchase_id'] = $data['purchase_id'];
        $data_insert['installment'] = $data['installment'];
        if (isset($data['description'])) {
            $data_insert['description'] = $data['description'];
        }
        $data_insert['rest'] = $rest - $data['installment'];

        if ($data_insert['rest'] == 0) {
            $db_where['id'] = $data['purchase_id'];
            $data_update['fully_pay'] = true;
            $this->utils_model->update('purchases', $db_where, $data_update);
        }
        
        return $this->utils_model->insert($this->table, $data_insert);
    }
}
 
