<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_kop_surat extends CI_Model
{
  private $table = 'letterheads';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }

    public function update($id, $data)
    {
        $data_update['content'] = $data["content"];

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }
}
 
