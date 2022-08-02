<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_calibrations extends CI_Model
{
    private $table = 'calibrations';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function create($data) 
    {
        // check if there's calibrations data
        $current_calibrations = $this->utils_model->getEdit("calibrations", array("order_id" => $data['order_id']));

        // delete calibration first if exists
        if ($current_calibrations !== null) {
            $this->utils_model->delete('calibrations', array('order_id' => $data['order_id']));
        }

        $listData = array(count($data['merk']), count($data['subjek']), count($data['petugas_kalibrasi']));
        sort($listData);


        for ($i=0; $i < $listData[count($listData) - 1]; $i++) { 
            $data_insert = array(
                'order_id' =>  $data['order_id'],
                'subject' => $data['subjek'][$i],
                'brand' => $data['merk'][$i],
                'calibration_officer' => $data['petugas_kalibrasi'][$i],
                'calibration_completion_date' => $data['tanggal_selesai_kalibrasi'][$i],
                'description' => $data['keterangan'][$i],
                'typist' => $data['typist'][$i],
            );

            $this->utils_model->insert($this->table, $data_insert);
        }

        if (!isset($data['submit'])) {
            $this->utils_model->update('orders'
                , array('id' => $data['order_id'])
                , array('tracking_number' => 3)
            );
        }

        return true;
    }

    public function update($id, $data)
    {
        if ($data['setuju'] === '1') {
            $data_update['tracking_number'] = 2;
        }

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }
}
