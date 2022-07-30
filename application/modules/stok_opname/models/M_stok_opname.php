<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_stok_opname extends CI_Model
{
    private $table = 'opnames';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
    }
    
    public function laporan_stok_opname($golongan = null)
    {
        $this->db
            ->select("
                p.created_at
                , t.name as type_name
                , p.name as product_name
                , p.stock
                , p.expired_date
                , 0 as empty
            ")
            ->from('products p')
            ->join('types t', 't.id = p.type');

        if (!is_null($golongan)) {
            $this->db->where('t.id', $golongan);
        }

        return $this->db->get()->result_array();
    }
}
