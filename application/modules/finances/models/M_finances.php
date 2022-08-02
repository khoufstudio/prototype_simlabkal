<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_finances extends CI_Model
{
    private $table = 'orders';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function update($id, $data)
    {
        if ($data['setuju'] === '1') {
            $data_update['tracking_number'] = 4;
        }

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }
}
