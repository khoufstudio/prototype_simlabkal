<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends MY_Controller
{
    private $table = "roles";
    private $num = 0;
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form', 'utility_helper');
        $this->load->model('roles/M_roles');
        $this->load->model('menus/M_menus');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);

        $this->template->load('template', 'roles/index', $data);
    }

    public function store()
    {
        $nama_role = $this->input->post('nama_role');
        $data = $this->M_roles->create();

        if ($data) {
            // insert log
            $this->log_model->create('tambah role');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data '.$nama_role.' telah tersimpan');
            redirect('roles/index','refresh');
        }

    }

    public function update($id)
    {
        $nama_role = $this->input->post('nama_role');
        $data = $this->M_roles->update($id);

        if ($data) {
            // insert log
            $this->log_model->create('tambah/update role');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data '.$nama_role.' telah diupdate');
            redirect('roles/index','refresh');
        }           
    }

	public function delete($id)
	{
		$nama_role = $this->input->post('nama_role');
        $data = $this->M_roles->delete($id);

        if ($data) {
            // insert log
            $this->log_model->create('hapus menu role');

        	$this->session->set_flashdata('form_message', 'Alhamdulillah data '.$nama_role.' telah dihapus');
        	redirect('roles/index','refresh');
        }
	}

    public function update_role($id)
    {
        $data = $this->input->post();
        $result = $this->M_roles->update_role($id, $data);

        if ($result) {
            // insert log
            $this->log_model->create('tambah/update menu role');

            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah diupdate');
            redirect('roles/index','refresh');
        }           
    }

    public function get_datatables_json()
    {
        $this->datatables
            ->select('id, name')                
            ->from($this->table)
            ->add_column('edit_button', 
                '<a href="'.base_url('roles/edit_role/$1').'" class="btn btn-success btn-xs"><i class="fa fa-lock"></i></a>
                <button class="btn btn-edit btn-primary btn-xs" value="$1"><i class="fa fa-pencil"></i></button>
                <form style="display: inline;" action="'.base_url('roles/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                </form>', 'id, name'
                );
        
        echo $this->datatables->generate();
    }

    public function edit_role($id)
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['list_menus'] = $this->utils_model->list_data_for_select('menus');
        $data['role_id'] = $id;
        $data['menus_id'] =  $this->M_menus->menu_based_role($id);

        $this->template->load('template', 'roles/edit_role', $data);
    }
}
