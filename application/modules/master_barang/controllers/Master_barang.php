<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Master_barang extends MY_Controller
{
    private $table = 'products';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Utils_model', 'utils_model');
        $this->load->helper('form', 'utility_helper');
        $this->load->model('Master_barang/M_master_barang');
        $this->load->library('datatables');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['form_success'] = $this->session->flashdata('form_success');

        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'master_barang/index', $data);
    }

    public function create()
    {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'master_barang/store';
        $data['action'] = 'add';
        $data['types'] = $this->utils_model->listData('types', null, 'id, name');
        $data['denominations'] = $this->utils_model->listData('denominations', null, 'id, name, size');
        $data['denominations_small'] = array_filter($data['denominations'], function ($denomination) { return $denomination['size'] == 'kecil'; });
        $data['denominations_large'] = array_filter($data['denominations'], function ($denomination) { return $denomination['size'] == 'besar'; });
        $data['cashier_name'] = $this->session->userdata('user')->nama;

        $data['product']['name'] = $this->input->post('nama_barang') ?? '';
        $data['product']['batch_number_product'] = $this->input->post('no_batch') ?? '';
        $data['product']['product_name'] = $this->input->post('nama_barang') ?? '';
        $data['product']['type'] = $this->input->post('golongan') ?? '';
        $data['product']['ownership'] = $this->input->post('kepemilikan') ?? '';
        $data['product_prices'] = array(
            array(
                'buying_price' => rupiahToInt($this->input->post('harga-beli-1')) ?? '',
                'selling_price' => rupiahToInt($this->input->post('harga-jual-1')) ?? '',
                'denomination_id' => $this->input->post('ukuran_kecil') ?? '',
            ),
            array(
                'buying_price' => rupiahToInt($this->input->post('harga-beli-2')) ?? '',
                'selling_price' => rupiahToInt($this->input->post('harga-jual-2')) ?? '',
                'denomination_id' => $this->input->post('ukuran_besar') ?? '',
            )
        );

        $data['denomination_conversions'] = array(
            'conversion_small' => $this->input->post('conversion_small') ?? '',
            'conversion_large' => $this->input->post('conversion_large') ?? '',
            'conversion_small_label' => $this->input->post('conversion_small') ?? '',
            'conversion_large_label' => $this->input->post('conversion_large') ?? '',
            'count' => $this->input->post('jumlah') ?? ''
        );

        $this->template->load('template', 'master_barang/create_edit', $data);
    }

    public function edit($id) {
        $data['base'] = strtolower(get_class($this));
        $data['form_action'] = 'master_barang/update/' . $id;
        $data['action'] = 'edit';
        $data['types'] = $this->utils_model->listData('types', null, 'id, name');
        $data['product'] = $this->utils_model->getEdit('products', array('id' => $id));
        $data['denominations'] = $this->utils_model->listData('denominations', null, 'id, name, size');
        $data['denominations_small'] = array_filter($data['denominations'], function ($denomination) { return $denomination['size'] == 'kecil'; });
        $data['denominations_large'] = array_filter($data['denominations'], function ($denomination) { return $denomination['size'] == 'besar'; });
        $data['cashier_name'] = $this->session->userdata('user')->nama;

        $data['product_prices'] = $this->M_master_barang->product_prices($id);
        $data['denomination_conversions'] = $this->M_master_barang->denomination_conversions($id);

        $this->template->load('template', 'master_barang/create_edit', $data);
    }

    public function store()
    {
        $data = $this->input->post();

        $this->form_validation->set_error_delimiters('', '');
        $validation_rules = $this->M_master_barang->get_validation_rules();

        if (!empty($data)) {
            if (isset($data['sizes']) && count($data['sizes']) == 2) {
                $validation_rules[] = array(
                    'field' => 'sizes2',
                    'label' => 'Ukuran',
                    'rules' => 'required',
                    'errors' => array('required' => 'Jumlah Konversi Satuan wajib diisi'),
                );
            }

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() != false) {
                $result = $this->M_master_barang->create($data);

                if ($result) {
                    // insert log
                    $this->log_model->create('tambah barang');

                    $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

                    redirect('master_barang/index','refresh');
                }
            } else {
                $this->create();
            }     
        } else {
            redirect('master_barang/create');
        }
    }

    public function update($id)
    {
        $data = $this->input->post();


        $this->form_validation->set_error_delimiters('', '');
        $validation_rules = $this->M_master_barang->get_validation_rules();

        $products = $this->utils_model->getEdit('products', array('id' => $id), 'name'); 

        // for remove validation duplicate nama_barang
        if ($data['nama_barang'] == $products['name']) {
            $validation_rules[0]['rules'] = 'required';
        }

        if (!empty($data)) {
            if (isset($data['sizes']) && count($data['sizes']) == 2) {
                $validation_rules[] = array(
                    'field' => 'sizes2',
                    'label' => 'Ukuran',
                    'rules' => 'required',
                    'errors' => array('required' => 'Jumlah Konversi Satuan wajib diisi'),
                );
            }

            $this->form_validation->set_rules($validation_rules);

            if ($this->form_validation->run() != false) {
                $result = $this->M_master_barang->update($id, $data);
                if ($result) {
                    // insert log
                    $this->log_model->create('update barang');

                    $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');

                    redirect('master_barang/index','refresh');
                }
            } else {
                $this->edit($id);
            }  
        }
    }

    public function get_datatables_json()
    {
        if ($custom_search = $this->input->post('custom_search')) {
            $stock = $custom_search['stok'];
            $operation = $custom_search['operasi'];
        }

        $this->datatables
            ->select("
                id
                , name
                , product_barcode
                , stock
                , product_type
                , ownership
                , buying_price
                , selling_price
                , expired_date
            ")
            ->add_column('action', 
                '<a href="'.base_url().'master_barang/edit/$1" class="btn btn-block btn-primary btn-xs item-edit" style="display: inline;"><i class="fa fa-pencil"></i></a>
                <form style="display: inline;" action="'.base_url('master_barang/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger btn-delete" type="submit"  style="display: inline;"><i class="fa fa-trash"></i></button>
                </form>', 'id, name'
            )
            ->from('master_barang');

        if (isset($stock)) {
            $this->datatables->where("stock $operation $stock");
        }

        $this->datatables->edit_column('buying_price', '$1', 'intToRupiah(buying_price)');
        $this->datatables->edit_column('selling_price', '$1', 'intToRupiah(selling_price)');
        $this->datatables->edit_column('expired_date', '$1', 'ymdtoDmy(expired_date)');

        echo $this->datatables->generate();
    }

    public function get_datatables_json_penjualan()
    {
        if ($custom_search = $this->input->post('custom_search')) {
            $stock = $custom_search['stok'];
            $operation = $custom_search['operasi'];
        }

        $this->datatables
            ->select("
                id
                , name
                , product_barcode
                , stock
                , selling_price
            ")
            ->add_column('action', 
                '<a href="'.base_url().'master_barang/edit/$1" class="btn btn-block btn-success btn-xs item-add" style="display: inline;"><i class="fa fa-plus"></i></a>', 'id'
            )
            ->from('master_barang');

        if (isset($stock)) {
            $this->datatables->where("stock $operation $stock");
        }

        $this->datatables->edit_column('selling_price', '$1', 'intToRupiah(selling_price)');

        echo $this->datatables->generate();
    }

    public function barang()
    {
        $id = $this->input->get('product_id');
        $name = $this->input->get('name');

        $result = $this->M_master_barang->selling_products(array("p.id" => $id));
        if (!$result) {
            $result = $this->M_master_barang->selling_products("p.name like '". $name . "%'");

            // search barcode
            if (!$result) {
                $result = $this->M_master_barang->selling_products("product_barcode = '". $name . "'");
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function product_price()
    {
        $product_id = $this->input->get('product_id');
        $denomination_id = $this->input->get('denomination_id');
        
        $result = $this->utils_model->getEdit("product_prices", 
            array(
                "denomination_id" => $denomination_id,
                "product_id" => $product_id
            )
        );

        // add multiplier
        $multiplier = $this->M_master_barang->multiplier_products($product_id, $denomination_id);

        $result["multiplier"] = $multiplier;
        // end add multiplier
        
        echo json_encode($result);
    }

    public function update_product_price()
    {
        $data = $this->input->post();
        $success = false;

        // check product price is exist or not
        $check_product_price = $this->utils_model->getEdit("product_prices", 
            array(
                "denomination_id" => $data['satuan'],
                "product_id" => $data['product_id']
            )
        );

        // insert or update buying_price
        if (isset($data['ubah_harga_beli']) && $data['ubah_harga_beli'] == 'on') {
            $data_insert_update['buying_price'] = rupiahToInt($data['price']);
            $data_where['product_id'] = $data['product_id'];
            $data_where['denomination_id'] = $data['satuan'];

            if ($check_product_price) {
                $result = $this->utils_model->update("product_prices", $data_where, $data_insert_update);
            } else {
                $data_insert_update['product_id'] = $data['product_id'];
                $data_insert_update['denomination_id'] = $data['satuan'];
                $result = $this->utils_model->insert('product_prices', $data_insert_update);
            }
        }

        // insert or update selling price
        if (isset($data['ubah_harga_jual']) && $data['ubah_harga_jual'] == 'on') {
            $data_insert_update['selling_price'] = rupiahToInt($data['selling_price']);
            $data_where['product_id'] = $data['product_id'];
            $data_where['denomination_id'] = $data['satuan'];

            if ($check_product_price) {
                $result = $this->utils_model->update("product_prices", $data_where, $data_insert_update);
            } else {
                $data_insert_update['product_id'] = $data['product_id'];
                $data_insert_update['denomination_id'] = $data['satuan'];
                $result = $this->utils_model->insert('product_prices', $data_insert_update);
            }
        }

        if ($result) {
            $success = true;
        }


        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => $success)));
    }

    public function delete($id)
    {
        $nama_master_barang = $this->input->post('name');

        $this->db->trans_start();
        // find data 
        $purchase_details = $this->utils_model->getEdit('purchase_details', array('product_id' => $id));

        if (!is_null($purchase_details)) {
            $data = false;
        } else {
            $data = $this->utils_model->delete('products', array('id' => $id));
        }
        $this->db->trans_complete();


        if ($data) {
            $form_message = 'Data '.$nama_master_barang.' telah dihapus';
            $form_success = true;
        } else {
            $form_message = 'Data '.$nama_master_barang.' gagal dihapus, karena telah digunakan';
            $form_success = false;
        }

        $this->session->set_flashdata('form_success', $form_success);
        $this->session->set_flashdata('form_message', $form_message);

        redirect('master_barang/index','refresh');
    }

    public function download_csv()
    {
        $filename = "Master Barang - " . date('d/m/Y') . " .csv";
        $delimiter = ";";

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: text/csv; ");

        $criteria = $this->input->get();
        $data = $this->utils_model->listData('products', null, "product_barcode, name, stock");

        if (count($data) > 0) {
            // create file pointer
            $file = fopen("php://memory", "w");

            $fields = array("No", "Barcode", "Nama Barang", "Stok");

            fputcsv($file, $fields, $delimiter);

            // insert data 
            foreach ($data as $index => $dt) {
                $fields = array($index + 1, $dt["product_barcode"], $dt["name"],$dt["stock"]);

                fputcsv($file, $fields, $delimiter);
            }
        }

        // move back to beginning of file
        fseek($file, 0);

        // output all remaining data on a file pointer
        fpassthru($file);

        exit;
    }

    private function ukuran_check($value)
    {
        $current_value = $value;

        return true;
    }
}
