<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class M_master_barang extends CI_Model
{
    private $table = 'products';

    private $validation_rules = array(
        array(
            'field' => 'nama_barang',
            'label' => 'Nama Barang',
            'rules' => 'required|is_unique[products.name]',
            'errors' => array(
                'required' => '%s wajib isi',
                'is_unique' => '%s telah digunakan'
            ),
        ),
        array(
            'field' => 'golongan',
            'label' => 'Golongan',
            'rules' => 'required',
            'errors' => array('required' => '%s wajib isi'),
        ),
        array(
            'field' => 'kepemilikan',
            'label' => 'Kepemilikan',
            'rules' => 'required',
            'errors' => array('required' => '%s wajib isi'),
        ),
        array(
            'field' => 'sizes[]',
            'label' => 'Ukuran',
            'rules' => 'required',
            'errors' => array('required' => 'Ukuran wajib diisi minimal 1 (Besar/Kecil)'),
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
    }

    public function create($data)
    {
        $data_insert['name'] = $data['nama_barang'];
        $data_insert['product_barcode'] = $data['kode_barang'];
        $data_insert['type'] = $data['golongan'];
        $data_insert['ownership'] = $data['kepemilikan'];
        $data_insert['batch_number_product'] = $data['no_batch'];

        $this->db->trans_start();
        $product_id = $this->utils_model->insert_masdet($this->table, $data_insert);

        $data_size = $data['sizes'];
        $data_size2 = isset($data['sizes2']) ? $data['sizes2'] : null;

        $this->add_detail_barang($data_size, $data_size2, $product_id);
        $this->db->trans_complete();

        return $data;
    }

    public function update($product_id, $data) 
    {
        $data_update['name'] = $data['nama_barang'];
        $data_update['product_barcode'] = $data['kode_barang'];
        $data_update['type'] = $data['golongan'];
        $data_update['ownership'] = $data['kepemilikan'];
        $data_update['batch_number_product'] = $data['no_batch'];

        $this->db->trans_start();
        $this->utils_model->update($this->table, array('id' => $product_id), $data_update);

        // delete all product_prices and denomination_conversions
        $this->utils_model->delete('product_prices', array('product_id' => $product_id));
        $this->utils_model->delete('denomination_conversions', array('product_id' => $product_id));

        $data_size = $data['sizes'] ?? null;
        $data_size2 = isset($data['sizes2']) ? $data['sizes2'] : null;

        $this->add_detail_barang($data_size, $data_size2, $product_id);

        $this->db->trans_complete();

        return $data;

    }

    public function selling_products($where)
    {
        $selling_product = $this->db
            ->select("
              p.id 
              , p.name 
              , p.product_barcode
              , d.size 
              , d.id as denomination_id
              , d.name as denomination_name
              , pp.buying_price 
              , pp.selling_price 
              , p.batch_number_product
            ")
            ->from("products p")
            ->join("product_prices pp", "p.id = pp.product_id")
            ->join("denominations d", "d.id = pp.denomination_id")
            ->where($where)
            ->get()
            ->result_array();

        if (count($selling_product) > 0) {
            foreach ($selling_product as $index => $product) {
                $multiplier = $this->multiplier_products($product['id'], $product['denomination_id']);
                $selling_product[$index]['multiplier'] = $multiplier;
            }
        }

        return $selling_product;
    }

    public function multiplier_products($product_id, $denomination_id) 
    {
        // find lowest denomination
        $lowest_denomination_param['select'] = 'd.id';
        $lowest_denomination_param['table'] = 'product_prices pp';
        $lowest_denomination_param['table_where'] = array('pp.product_id' => $product_id);
        $lowest_denomination_param['table_detail'] = 'denominations d';
        $lowest_denomination_param['on_table'] = 'pp.denomination_id';
        $lowest_denomination_param['on_table_detail'] = 'd.id';
        $lowest_denomination_param['order_by'] = 'd.priority';
        $lowest_denomination_param['order_by_asc_desc'] = 'desc';
        $lowest_denomination_param['limit'] = 1;

        $lowest_denomination = $this->utils_model->listDataDetail($lowest_denomination_param)[0]["id"];
        // end, find lowest denomination

        // find multiplier 
        $multiplier = 1;
        do {
            $denomination_conversion =  $this->utils_model->getEdit("denomination_conversions", 
                array(
                    "denomination_id" => $denomination_id,
                    "product_id" => $product_id
                )
            );

            $denomination_id = isset($denomination_conversion["denomination_conversion_id"]) ? $denomination_conversion["denomination_conversion_id"] : null;
            if (is_null($denomination_id)) {
                break;
            }
            $multiplier *= $denomination_conversion["count"];
            if ($denomination_id == $lowest_denomination) {
                $denomination_conversion =  $this->utils_model->getEdit("denomination_conversions", 
                    array(
                        "denomination_conversion_id" => $denomination_id,
                        "product_id" => $product_id
                    )
                );
                $multiplier *= $denomination_conversion["count"];
                break;
            }
        
        } while (true);
        // end, find multiplier 

        return $multiplier;
    }

    public function denomination_conversions($product_id) 
    {
       $query = $this->db; 

       $query->select("d2.id conversion_small, d2.name conversion_small_label, d3.id conversion_large, d3.name conversion_large_label, dc.count")
           ->from("denomination_conversions dc")
           ->join("denominations d2", "d2.id = dc.denomination_id")
           ->join("denominations d3", "d3.id = dc.denomination_conversion_id")
           ->where("dc.product_id", $product_id);

        return $query->get()->row_array();
    }

    public function get_validation_rules()
    {
        return $this->validation_rules;
    }

    public function product_prices($product_id)
    {
        $query = "SELECT `pp`.`product_id`, `pp`.`denomination_id`, `products`.`name`, `pp`.`buying_price`, `pp`.`selling_price`, `pp`.`size`, `pp`.`denomination` FROM ( select p.product_id, `p`.`buying_price`, `p`.`selling_price`, `p`.`denomination_id`, `d`.`name` `denomination`, d.size from product_prices p left join denominations d on p.denomination_id = d.id ) pp LEFT JOIN `products` ON `pp`.`product_id` = `products`.`id` WHERE `product_id` = '$product_id'";

        $result = $this->db->query($query)->result_array();

        return $result;
    }

    public function add_detail_barang($data_size, $data_size2, $product_id)
    {

        if (!is_null($data_size) && count($data_size) > 0) {
            foreach ($data_size as $ds) {
                $product_detail = explode("|*", $ds);   
                list($denomination_id, $buying_price, $selling_price) = $product_detail;

                if ($denomination_id != '') {
                    $data_product_detail["product_id"] = $product_id;
                    $data_product_detail["denomination_id"] = $denomination_id;
                    $data_product_detail["buying_price"] = $buying_price;
                    $data_product_detail["selling_price"] = $selling_price;

                    $this->utils_model->insert('product_prices', $data_product_detail);
                }
            }
        }


        if (!is_null($data_size2)) {
            $size_detail = explode("|*", $data_size2);   
            list($denomination_conversion_id, $denomination_id, $count) = $size_detail;
            if ($denomination_id != '') {
                $data_size_detail["product_id"] = $product_id;
                $data_size_detail["denomination_id"] = $denomination_id;
                $data_size_detail["denomination_conversion_id"] = $denomination_conversion_id;
                $data_size_detail["count"] = $count; 

                $this->utils_model->insert('denomination_conversions', $data_size_detail);
            }
        }
    }
}
 
