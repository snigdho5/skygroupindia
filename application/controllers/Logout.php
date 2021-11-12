<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
		parent::__construct();
		error_reporting(0);
	}
	
 /**
  * Load Logout Method
  * 
  * @param1       
  * @return       view page
  * @access       public
  * @author       M.K.Sah
  * @copyright    N/A
  * @link         application/Logout
  * @since        1st April 2020
  * @deprecated   N/A
  **/
	
	public function index() {
		check_login();
		session_destroy();
		$this->CommonModel->delete_cookies();
		redirect(base_url('login'));
	}
}
?>