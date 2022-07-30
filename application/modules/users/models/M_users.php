<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model
{
    private $table = 'users'; // nama table database
  
    public function __construct()
    {
        parent::__construct();
        $this->load->library('encryption');
        $this->load->model('Utils_model', 'utils_model');
    }

    public function create_user()
    {
        $data_insert['nama'] = $_POST['nama'];
        $data_insert['username'] = $_POST['usernamex'];
        $data_insert['password'] = $this->encryption->encrypt($_POST['passwordx']);
        $data_insert['profile_picture'] = $this->upload_image();
        $data_insert['role'] = $_POST['role'];

        $result = $this->utils_model->insert($this->table, $data_insert);

        return $result;
    }

    public function get_edit($id)
    {
        $arr_where['id'] = $id;
        $this->db->where($arr_where);
        $row = $this->db->get($this->table)->row_array();

        $row['password'] = $this->encryption->decrypt($row["password"]);

        return $row;
    }

    public function update_user($id)
    {
        $arr_where['id'] = $id;
        $data_update['nama'] = $_POST['nama'];
        $data_update['username'] = $_POST['usernamex'];
        $data_update['profile_picture'] = $this->upload_image();
        if (!empty($_POST['passwordx'])) {
            $data_update['password'] = $this->encryption->encrypt($_POST['passwordx']);
        }
        if (!empty($_POST['role'])) {
            $data_update['role'] = $_POST['role'];
        }

        $result = $this->utils_model->update($this->table, $arr_where, $data_update);

        return $result;
    }

    public function upload_image()
    {
        $config['upload_path'] = './uploads/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_picture')) {
            return $this->upload->data("file_name");
        }

        return "";
    }
}
