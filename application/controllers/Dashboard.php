<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		if( $this->session->userdata('user_login_session') != "true" && $this->session->userdata('user_id') =='' )
	    {
			$data['meta_title'] = 'Sky Group India';
			$data['meta_desc']  = 'Sky Group India Description';
			$this->load->view('login/login',$data);
	    }
		//error_reporting(0);
	}
	
	/**
	* Load Dashboard Page Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Dashboard
	* @since        1st June 2021
	* @deprecated   N/A
	**/
	
	public function index(){
		
		check_login();
		$data['meta_title'] = 'Dashboard';
      	$data['meta_desc']  = 'Dashboard Description';
		
		$data['content'] 	= 'dashboard/index';
		$this->load->view('layout_home', $data);
	}
}
?>