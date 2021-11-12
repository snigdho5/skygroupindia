<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		//$this->load->library('mongo_db', array('activate'=>'default'),'mongo_db');
		
		if( $this->session->userdata('user_login_session') != "true" && $this->session->userdata('user_id') =='' )
		{
			$data['meta_title'] = 'Sky Group India';
			$data['meta_desc']  = 'Sky Group India Description';
			$this->load->view('login/login',$data);
		} else {
			redirect(base_url('dashboard'));
		}
		//error_reporting(0);
	}

	/**
	* Load Login Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/login
	* @since        1st June 2021
	* @deprecated   N/A
	**/

	public function index(){
		
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);

		$this->form_validation->set_rules('username', 'username', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'password', 'trim|required');

		if ( !$this->form_validation->run() === FALSE )
		{
			$md5_data   = md5(trim($data['password']));
			$salt_key   = get_encript_id(trim($data['password']));
			$password   = $md5_data.$salt_key;
			//$user_id    = $this->db->escape_like_str($data['username']);
			$user_id    = $data['username'];
			
			$credentials = array(
				'email'      => $user_id,
				'password'   => $password,
				'status' 	 => 1
			);
			$user_exsist = $this->CommonModel->RetriveRecordByWhere(TBL_USERS,$credentials);
			
			if (!empty($user_exsist) && count($user_exsist) === 1 && $user_exsist[0]['email'] === $user_id ) 
			{
				$this->CommonModel->set_cookies($user_id,trim($data['password']));
				$this->CommonModel->unlock_account($user_id);
				
				$this->session->set_userdata('user_db_id', $user_exsist[0]['_id']);
				$this->session->set_userdata('user_id', $user_exsist[0]['email']);
				$this->session->set_userdata('user_login_session', true);
				redirect(base_url('dashboard'));
			}
			else{
				$login_attempt = $this->CommonModel->block_account($user_id);
				
				if( $login_attempt >= 3){
					$msg = 'Your user id has been blocked as you have entered wrong password consecutively more than three times. Please contact to admin to unblock.';
				}else{
					$msg = 'Your user id will be blocked if you enter wrong password consecutively more than three times';
				}
				
				$this->session->set_flashdata('error', $msg);
				redirect(base_url('login'));
			}
		}else{
			$data['meta_title'] = 'Sky Group India';
			$data['meta_desc']  = 'Sky Group India Description';
			$this->load->view('login/login',$data);
		}
	}
}
?>