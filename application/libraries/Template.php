<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    // CI instance
    private $CI;

    // Template Data
    var $template_data = array();

    
    public function __construct()
    {
        $this->CI =& get_instance();
        date_default_timezone_set("Asia/Bangkok");
    }

    public function set($content_area, $value)
    {
        $this->template_data[$content_area] = $value;
    }

    public function load($template = '', $view = '', $view_data = array(), $return = FALSE)
    {
        $menus = $this->CI->M_menus->menu_display();
        $view_data['menus'] = $menus;
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->CI->load->view($template, $this->template_data);
    }
}
/* End of file Template.php */
 ?>
