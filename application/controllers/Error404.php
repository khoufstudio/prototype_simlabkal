<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error404 extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{	
		$this->template->load('template', '404');
	}

}

/* End of file Error404.php */
/* Location: ./application/controllers/Error404.php */
?>