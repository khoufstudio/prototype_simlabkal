<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_retur_pembelian extends CI_Model
{
    private $table = 'purchase_returns';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Kartu_stok/M_kartu_stok');
        $this->load->model('Hutang/M_hutang');
        $this->load->model('Master_supplier/M_master_supplier');
    }
    
    public function create($data) 
    {
        $this->db->trans_start();
        
        // insert ke purchase
        $purchase_detail_id = $data['id_detail_pembelian'];
        $data_purchase_detail = $this->utils_model->getEdit('purchase_details', array('id' => $purchase_detail_id));

        // update field retur penjualan di table purchase_return
        $data_where['id'] = (string) $purchase_detail_id;
        $data_update['purchase_return'] = 1;
        $data_update['current_stock'] = $data_purchase_detail['current_stock'] - $data["jumlah_retur_barang"];
        $this->utils_model->update('purchase_details', $data_where, $data_update); 

        $data_where_product["id"] = $product_id = $data_purchase_detail["product_id"];
        $product = $this->utils_model->getEdit('products', $data_where_product);
        
        // update product quantity
        $data_update_product["stock"] = $stock = $product["stock"] - $data["jumlah_retur_barang"];
        $this->utils_model->update('products', $data_where_product, $data_update_product); 

        // insert to purchase_return
        $data_insert['purchase_return_code'] = $this->last_purchase_return_code();
        $data_insert['purchase_detail_id'] = $purchase_detail_id;
        $data_insert['quantity'] = $quantity = $data["jumlah_retur_barang"];
        $result = $this->utils_model->insert($this->table, $data_insert); 

        // insert to payment debts when pembayaran is credit
        $data_payment_debt['installment'] = $data_purchase_detail['price'] * $data["jumlah_retur_barang"];
        $data_payment_debt['purchase_id'] = $data_purchase_detail['purchase_id'];
        $data_payment_debt['description'] = 'Retur Pembelian';
        $this->M_hutang->create($data_payment_debt);

        $transaction_code = "RB" . $data_insert['purchase_return_code'];
        $expired_date = $data_purchase_detail['expired_date'];
        $supplier = $this->M_master_supplier->get_supplier_name_by_purchase_id($data_purchase_detail['purchase_id']);

        // insert to card stock
        $data_kartu_stok = array(
            'transaction_code' => $transaction_code,
            'product_id' => $product_id,
            'supplier_name' => $supplier['name'],
            'quantity' => $quantity,
            'stock' => $stock,
            'expired_date' => $expired_date
        );

        $this->M_kartu_stok->create($data_kartu_stok);

        $this->db->trans_complete();

        return $result;
    }
    
    public function last_purchase_return_code()
    {
        $purchase_return_code_last_value = $this->utils_model->get_last_value($this->table, 'purchase_return_code');

        if ($purchase_return_code_last_value == 0) {
            $purchase_return_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
        } else {
            if (substr(date('Y'), -2) . date('m') ==  substr($purchase_return_code_last_value, 0, 4)) {
                $purchase_return_code = $purchase_return_code_last_value + 1;
            } else {
                $purchase_return_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
            }
        }

        return $purchase_return_code;
    }
}
