<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
	private $table = "users";
	private $num = 0;
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Utils_model', 'utils_model');
		$this->load->library('datatables');
		$this->load->library('encryption');
		$this->load->model('users/M_users');
	}

	public function index()
	{
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['data'] = $this->utils_model->listData($this->table, null);

        $this->template->load('template', 'users/index', $data);
    }

    public function store() {
        $result = $this->M_users->create_user();

        $aksi = 'ditambahkan';

        if ($result) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah '.$aksi.'');
            redirect('users','refresh');
        }  
    }

    public function update($id)
    {
        // validasi input
        if ($_POST) {
            $result = $this->M_users->update_user($id);
            $aksi = 'diupdate';

            if ($result) {
                $this->session->set_flashdata('form_message', 'Alhamdulillah data telah '.$aksi.'');
                if ($this->session->username == 'admin') {
                  redirect('users','refresh');
                } else {
                  redirect('users/edit/' . $id,'refresh');
                }
            } else {
                echo "data gagal";
            }
        }
    }

    public function destroy($id)
    {
        $arrWhere['id'] = $id;
        $result = $this->utils_model->getEdit($this->table, $arrWhere);
        $query = $this->utils_model->delete($this->table, $arrWhere);
        if ($query) {
            // message delete success 
            $this->session->set_flashdata('form_message', 'Data '. $result['nama'] .' telah dihapus'); redirect('users','refresh'); 
        } 
    } 
    
    // untuk edit via modal 
    public function get_edit($id) { 
        $arrWhere['id'] = $id; 
        $data = $this->M_users->get_edit($id); 
        $this->output ->set_content_type('application/json') ->set_output(json_encode($data)); 
    }

    public function edit($id)
    {
        $data['aksi'] = 'edit';
        $data['user'] = $this->M_users->get_edit($id); 
        $data['role'] = $this->utils_model->listData('roles', null);
        $this->template->load('template', 'users/create_edit', $data);
    }

    public function create()
    {
        $data['aksi'] = 'tambah';
        $data['role'] = $this->utils_model->listData('roles', null);
        $this->template->load('template', 'users/create_edit', $data);
    }

    public function get_datatables_json()
    {
        $this->datatables->select('id, nama, username')
            ->from($this->table)
            ->add_column('view',
              '<a href="'.base_url().'users/edit/$1" class="btn-sm btn-success"><i class="fa fa-edit"></i>  Edit</a> 
              <a href="'.base_url().'users/destroy/$1" class="btn-sm btn-danger item_hapus" id="item_hapus"><i class="fa fa-remove"></i>  Hapus</a>', 'id'
            )
            ->add_column('num', $this->num++);
        echo $this->datatables->generate();
    }
}

