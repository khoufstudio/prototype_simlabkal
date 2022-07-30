<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * M_menus
 */
class M_menus extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
    }

    public function create()
    {
        $data['name'] = $this->input->post('name');
        $data['parent_id'] = $this->input->post('parent_id');
        $data['order_number'] = $this->input->post('order_number');
        $data['icon'] = $this->input->post('icon');

        if ($data['parent_id'] == "root" || $data['parent_id'] == "") {
            $data['parent_id'] = NULL;
        }
        $data['link'] = $this->input->post('link');

        return $this->utils_model->insert('menus', $data);
    }

    public function update($id)
    {
        $dataWhere['id'] = $id;
        $data['name'] = $this->input->post('name');
        $data['parent_id'] = $this->input->post('parent_id');
        $data['order_number'] = $this->input->post('order_number');
        $data['icon'] = $this->input->post('icon');
        $data['link'] = $this->input->post('link');
        if ($data['parent_id'] == "root" || $data['parent_id'] == "") {
            $data['parent_id'] = NULL;
        }
        return $this->utils_model->update('menus', $dataWhere, $data);
    }

    public function delete($id)
    {
        $dataWhere['id'] = $id;

        return $this->utils_model->delete('menus', $dataWhere);
    }  

    public function menu_display() {
        $menus = $this->utils_model->listData("menus", array("parent_id" => NULL), null, array('order_by' => 'order_number'));
        $role_id = $this->session->user->role;
        $menu_ids = $this->menu_based_role($role_id);

        $menu_display = '';
        foreach ($menus as $menu) {
            // check child 
            $child_menus = $this->utils_model->listData("menus", array("parent_id" => $menu['id']), null, array('order_by' => 'order_number'));
            if (count($child_menus) > 0) {
                // has child
                $child_menu_links = array();
                $menu_display_link = '';
                foreach ($child_menus as $cm) {
                    if (in_array($cm['id'], $menu_ids)) {
                        $menu_display_link .= '<li class="' .($this->uri->segment(1) == $cm['link'] ? 'active' : '') . '"><a href="' . base_url($cm['link']) . '"><i class="fa fa-circle-o"></i> <span>' . $cm["name"] . '</span></a></li>';   
                        array_push($child_menu_links, $cm['link']);
                    }
                }

                if (in_array($cm['id'], $menu_ids)) {
                    $menu_display .= '<li class="treeview ' . ((in_array($this->uri->segment(1), $child_menu_links)) ? "active" : ""). '">
                          <a href="#">
                              <i class="fa ' . $menu['icon'] . '"></i>
                              <span>'. $menu['name'] .'</span>
                              <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                              </span>
                          </a>
                          <ul class="treeview-menu">';
                          $menu_display .= $menu_display_link;
                          $menu_display .= '</ul>
                      </li>';
                }
          } else if (in_array($menu['id'], $menu_ids)) {
              $link = $menu['link'];
              // doesn't have child
              $menu_display .= '<li class="'. (($this->uri->segment(1) == $link) ? 'active' : '') .'"><a href="' . base_url() . $link . '"><i class="fa ' . $menu['icon'] . '"></i> <span>'. $menu["name"]. '</span></a></li>';
          }
        }

        return $menu_display;
    }

    function menu_based_role($id)
    {
        $menu_ids = $this->utils_model->listData('menu_roles', array('role_id' => $id), 'menu_id');
        $menus_id = array();

        foreach ($menu_ids as $menu_id) {
            array_push($menus_id, $menu_id['menu_id']);
        }

        return $menus_id;
    }
}
