<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class M_user extends CI_Model {
		public function getActiveUserByKey($key) {
			$this->db->where ('username', $key );
			$query = $this->db->get ('users');
			
			return $query->row();
		}
	}
?>
