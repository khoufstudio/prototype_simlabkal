<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_surat_pemesanan extends CI_Model
{
	private $table = 'orders';

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function create()
    {
        $input_post = $this->input->post();

        // start transact 
        $this->db->trans_start();

        $data['customer_name'] = $input_post['kepada'];
        $data['order_date'] = parse_date_db($input_post['tanggal']);

        $this->utils_model->insert_autoincrement_id($this->table, $data);
        $order_id = $this->db->insert_id();

        foreach ($input_post["products"] as $product) {
            $product_detail = explode("|", $product);   
            $order_detail['order_id'] = $order_id;
            $order_detail['product_id'] = $product_detail[0];
            $order_detail['quantity'] = $product_detail[1];
            $order_detail['description'] = $product_detail[2];

            $this->utils_model->insert('order_details', $order_detail);
        }

        // end transact 
        $this->db->trans_complete();

        return true;
    }

    public function update($id, $data)
    {
        $data_update['name'] = $data["nama"];
        $data_update['address'] = $data["alamat"];
        $data_update['contact'] = $data["nomor_kontak"];

        return $this->utils_model->update($this->table, array('id' => $id), $data_update);
    }

    public function order_detail($id)
    {
        $result = $this->db->select('p.name as product_name, od.quantity, od.description')
            ->from('order_details od')
            ->join('products p', 'p.id = od.product_id')
            ->where('od.order_id', $id)
            ->get()->result();

        return $result;
    }
}
 
