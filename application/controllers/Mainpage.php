<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainPage extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    function __construct() 
    {
        parent::__construct();
    }

    public function index()
    {
        // echo "under construction";
        $this->load->view('mainpage');
    }

    public function tracking($order_number)
    {
        $data = $this->utils_model->getEdit('orders', array('order_number' => $order_number), 'tracking_number');
        $tracking_number = $data['tracking_number'] ?? null;

        $result = array(
            'tracking_number' => $tracking_number
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }
}
