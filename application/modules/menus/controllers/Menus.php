<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MY_Controller
{
    private $table = "menus";
    private $num = 0;
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form', 'utility_helper');
        $this->load->model('menus/M_menus');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['form_message'] = $this->session->flashdata('form_message');
        $data['username'] = ucfirst($this->session->username);
        $data['menu_select_val'] = $this->utils_model->list_data_for_select('menus');
        // add root to menus
        array_unshift($data['menu_select_val'], array('id' => 'root', 'name' => 'Root'));

        $this->template->load('template', 'menus/index', $data);
    }

    public function store()
    {
        $data = $this->M_menus->create();

        if ($data) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data telah tersimpan');
            redirect('menus/index','refresh');
        }

    }

    public function update($id)
    {
        $namaMenu = $this->input->post('name');
        $data = $this->M_menus->update($id);

        if ($data) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data '.$namaMenu.' telah diupdate');
            redirect('menus/index','refresh');
        }           
    }

    public function delete($id)
    {
        $namaMenu = $this->input->post('nama_menu');
        $data = $this->M_menus->delete($id);

        if ($data) {
            $this->session->set_flashdata('form_message', 'Alhamdulillah data '.$namaMenu.' telah dihapus');
            redirect('menus/index','refresh');
        }
    }

    public function get_datatables_json()
    {
        $this->datatables
            ->select("
                m.id,
                m.name,
                m.order_number,
                IFNULL(m2.name, 'ROOT') as parent_name
            ")                
            ->from($this->table . ' as m')
            ->join($this->table . ' as m2', 'm.parent_id = m2.id', 'left')
            ->order_by('m.parent_id, m.order_number', 'asc')
            ->add_column('edit_button', 
               '<a href="'.base_url().'menus/edit/$1" class="btn btn-xs btn-primary item-edit"><i class="fa fa-edit"></i></a>
                <form style="display: inline;" action="'.base_url('menus/delete/$1').'" method="post">
                    <input type="hidden" name="name" value="$2">  
                    <button class="btn btn-xs btn-danger btn-delete" type="submit"  style="display: inline;"><i class="fa fa-trash"></i></button>
                </form>', 'id, name'
                );
        
        echo $this->datatables->generate();
    }

    public function edit($id)
    {
        $select = "name, link, order_number, parent_id, icon";
        $result = $this->utils_model->getEdit("menus", array("id" => $id), $select);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
