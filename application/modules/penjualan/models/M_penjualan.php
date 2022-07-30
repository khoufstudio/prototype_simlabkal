<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_penjualan extends CI_Model
{
    private $table = 'sellings';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->model('Kartu_stok/M_kartu_stok');
    }
    
    public function create($data) 
    {
        $this->db->trans_start();
        // insert ke selling
        $data_selling['selling_code'] = $data['kode_penjualan'];
        $data_selling['customer_id'] = $data['pelanggan'];
        $data_selling['payment'] = $data['pembayaran'];
        $data_selling['total'] = rupiahToInt($data['jumlah_penjualan']);
        $data_selling['total_buying'] = $data['jumlah_pembelian'];

        if ($data['pembayaran'] == 'kredit') {
            $data_selling['fully_pay'] = 0;
        }
        
        $id_selling = $this->utils_model->insert_masdet($this->table, $data_selling);
        foreach ($data["products"] as $product) {
            $product_detail = explode("|", $product);   
            list($product_id, $batch_number, $quantity, $price, , $buying_price) = $product_detail;
            $data_selling_detail["selling_id"] = $id_selling;
            $data_selling_detail["product_id"] = $product_id;
            $data_selling_detail["batch_number"] = $batch_number;
            $data_selling_detail["quantity"] = $quantity;
            $data_selling_detail["price"] = rupiahToInt($price);
            $data_selling_detail["buying_price"] = (int) $buying_price;

            $this->utils_model->insert('selling_details', $data_selling_detail);

            if ($quantity > 0) {
                $data_where["id"] = $product_id;
                $current_product = $this->utils_model->getEdit("products", $data_where);
                $updated_stock['stock'] = $stock = $current_product["stock"] - $quantity;

                $this->utils_model->update("products", $data_where, $updated_stock);
            }

            $transaction_code = "PJ" . $data['kode_penjualan'];
            $customer = $this->utils_model->getEdit('customers', array('id' => $data['pelanggan']), 'name');
            $expired_date = $current_product['expired_date'];

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

        }

        $this->db->trans_complete();

        return $data_selling;
    }

    public function last_selling_code()
    {
        $selling_code_last_value = $this->utils_model->get_last_value($this->table, 'selling_code');

        if ($selling_code_last_value == 0) {
            $selling_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
        } else {
            if (substr(date('Y'), -2) . date('m') ==  substr($selling_code_last_value, 0, 4)) {
                $selling_code = $selling_code_last_value + 1;
            } else {
                $selling_code = substr(date('Y'), -2) . date('m') . sprintf('%04d', 1);
            }
        }

        return $selling_code;
    }

    public function last_invoice_number()
    {
        $invoice_number_last_value = $this->utils_model->get_last_value($this->table, 'invoice_number');

        if ($invoice_number_last_value == 0) {
            $invoice_number = substr(date('Y'), -2) . date('m') . date('d'). sprintf('%04d', 1);
        } else {
            if (substr(date('Y'), -2) . date('m') . date('d') ==  substr($invoice_number_last_value, 0, 4)) {
                $invoice_number = $invoice_number_last_value + 1;
            } else {
                $invoice_number = substr(date('Y'), -2) . date('m') . date('d'). sprintf('%04d', 1);
            }
        }

        return $invoice_number;
    }

    public function selling_detail($selling_id)
    {
        $selling_detail_param['table'] = 'selling_details';
        $selling_detail_param['table_where'] = array('selling_id' => $selling_id);
        $selling_detail_param['table_detail'] = 'products';
        $selling_detail_param['on_table'] = 'selling_details.product_id';
        $selling_detail_param['on_table_detail'] = 'products.id';
        $selling_detail_param['select'] = 'selling_details.*, products.name';
        $selling_detail= $this->utils_model->listDataDetail($selling_detail_param);

        return $selling_detail;
    }

}
