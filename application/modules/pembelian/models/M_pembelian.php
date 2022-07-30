<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_pembelian extends CI_Model
{
    private $table = 'purchases';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Kartu_stok/M_kartu_stok');
    }
    
    public function create($data) 
    {
        // start transact 
        $this->db->trans_start();

        // insert ke purchase
        $data_purchase['purchase_code'] = $data['kode_pembelian'];
        $data_purchase['supplier_id'] = $data['supplier'];
        $data_purchase['invoice_number'] = $data['no_faktur'];
        $data_purchase['payment'] = $data['pembayaran'];
        if ($data['due_date']) {
            $data_purchase['due_date'] = parse_date_db($data['due_date']);
        }
        $data_purchase['total'] = $data['jumlah_pembelian'];
        if ($data['pembayaran'] == 'kredit') {
            $data_purchase['fully_pay'] = 0;
        }
        
        $id_purchase = $this->utils_model->insert_masdet($this->table, $data_purchase);
        foreach ($data["products"] as $product) {
            $product_detail = explode("|", $product);   
            list($product_id, $batch_number, $quantity, $price, $expired_date) = $product_detail;
            $expired_date = parse_date_db($expired_date);
            $data_purchase_detail["purchase_id"] = $id_purchase;
            $data_purchase_detail["product_id"] = $product_id;
            $data_purchase_detail["batch_number"] = $batch_number;
            $data_purchase_detail["expired_date"] = $expired_date;
            $data_purchase_detail["quantity"] = $quantity;
            $data_purchase_detail["current_stock"] = $quantity;
            $data_purchase_detail["price"] = $price;

            $this->utils_model->insert('purchase_details', $data_purchase_detail);

            // update product batch number
            $data_product['batch_number_product'] = $batch_number;
            $data_product_where['id'] = $product_id;
            $this->utils_model->update('products', $data_product_where, $data_product);

            // insert to card_stocks
            $transaction_code = "PB" . $data['kode_pembelian'];
            $supplier = $this->utils_model->getEdit('suppliers', array('id' => $data['supplier']), 'name');

            if ($quantity > 0) {
                $data_where["id"] = $product_id;
                $current_stock = $this->utils_model->getEdit("products", $data_where);
                $updated_product['stock'] = $stock = $current_stock["stock"] + $quantity;
                $updated_product['expired_date'] = $expired_date;

                $this->utils_model->update("products", $data_where, $updated_product);
            }

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
        }

        // end transact 
        $this->db->trans_complete();

        return $data_purchase;
    }

    public function last_purchase_code()
    {
        $purchase_code_last_value = $this->utils_model->get_last_value($this->table, 'purchase_code');

        if ($purchase_code_last_value == 0) {
            $purchase_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
        } else {
            if (substr(date('Y'), -2) . date('m') ==  substr($purchase_code_last_value, 0, 4)) {
                $purchase_code = $purchase_code_last_value + 1;
            } else {
                $purchase_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
            }
        }

        return $purchase_code;
    }
}
