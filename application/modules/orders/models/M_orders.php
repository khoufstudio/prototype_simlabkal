<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_orders extends CI_Model
{
    private $table = 'orders';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function create($data) 
    {
        $user = $this->session->user;

        $data_insert = array(
            'user_id' => $user->id,
            'order_number' =>  $data['order_number'],
            'order_date' => $data['order_date'],
            'owner' => $data['owner'],
            'contact_person' => $data['contact_person'],
            'address' => $data['address'],
            'spm' => $data['spm'],
            'tracking_number' => 1
        );

        $result = $this->utils_model->insert($this->table, $data_insert);

        return $result;
    }
}
