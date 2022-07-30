<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

/* End of file Authuser.php */

class Authuser  
{
    protected $CI;
    const USER_KEY = 'username';

    public function __construct()
    {
        $this->CI =& get_instance(); // assign CodeIgniter super-object
        $this->CI->load->library('session');
        $this->CI->load->library('encryption');
    }

    public function login($key, $pass)
    {
        $this->CI->load->model('Auth/M_user');

        $user_data = $this->CI->M_user->getActiveUserByKey($key);

        if ($user_data) {
            $passwordDecrypt = $this->CI->encryption->decrypt($user_data->password);

            if ($pass == $passwordDecrypt) {                
                $this->CI->session->set_userdata(self::USER_KEY, $key);
                $this->CI->session->set_userdata('user', $user_data);
                

                return null;
            }
        }

        return "Username dan Password salah !";
    }

    public function isLogged()
    {
        return (bool) $this->CI->session->userdata(self::USER_KEY);
    }

    public function logout()
    {
        $this->CI->session->unset_userdata(self::USER_KEY);   
    }
    
}




?>