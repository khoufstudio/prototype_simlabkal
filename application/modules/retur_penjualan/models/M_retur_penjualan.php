<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_retur_penjualan extends CI_Model
{
    private $table = 'selling_returns';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Kartu_stok/M_kartu_stok');
        $this->load->model('Master_supplier/M_master_supplier');
        $this->load->model('Master_pelanggan/M_master_pelanggan');
    }
    
    public function create($data) 
    {
        $this->db->trans_start();

        // insert ke selling
        $selling_detail_id = $data['id_detail_penjualan'];
        $data_selling_detail = $this->utils_model->getEdit('selling_details', array('id' => $selling_detail_id));       

        // update field retur penjualan di table selling_return
        $data_where['id'] = $data_selling_detail['id'];
        $data_update['selling_return'] = 1;
        $data_update['return_quantity'] = $data_selling_detail['return_quantity'] + $data["jumlah_retur_barang"];
        $this->utils_model->update('selling_details', $data_where, $data_update); 
        
        // update product quantity
        $data_where_product["id"] = $product_id = $data_selling_detail["product_id"];
        $product = $this->utils_model->getEdit('products', $data_where_product);        

        $data_update_product["stock"] = $stock = $product["stock"] + $data["jumlah_retur_barang"];
        $this->utils_model->update('products', $data_where_product, $data_update_product); 

        // insert to selling_return
        $data_insert['selling_return_code'] = $this->last_selling_return_code();
        $data_insert['selling_detail_id'] = $selling_detail_id;
        $data_insert['price'] =  $data_selling_detail["price"];
        $data_insert['quantity'] = $quantity = $data["jumlah_retur_barang"];
        $result = $this->utils_model->insert($this->table, $data_insert); 

        $transaction_code = "RJ" . $data_insert['selling_return_code'];
        $expired_date = $product['expired_date'];
        $customer = $this->M_master_pelanggan->get_customer_name_by_selling_id($data_selling_detail['selling_id']);

        // insert to card stock
        $data_kartu_stok = array(
            'transaction_code' => $transaction_code,
            'product_id' => $product_id,
            'supplier_name' => $customer['name'],
            'quantity' => $quantity,
            'stock' => $stock,
            'expired_date' => $expired_date
        );

        $this->M_kartu_stok->create($data_kartu_stok);

        $this->db->trans_complete();
        
        return $result;
    }
    
    public function last_selling_return_code()
    {
        $selling_return_code_last_value = $this->utils_model->get_last_value($this->table, 'selling_return_code');

        if ($selling_return_code_last_value == 0) {
            $selling_return_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
        } else {
            if (substr(date('Y'), -2) . date('m') ==  substr($selling_return_code_last_value, 0, 4)) {
                $selling_return_code = $selling_return_code_last_value + 1;
            } else {
                $selling_return_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
            }
        }

        return $selling_return_code;
    }
}
