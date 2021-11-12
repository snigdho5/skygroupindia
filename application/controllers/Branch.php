<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		if( $this->session->userdata('user_login_session') != 1 && $this->session->userdata('user_id') =='' )
		{
			$data['meta_title'] = 'Sky Group India';
			$data['meta_desc']  = 'Sky Group India Description';
			$this->load->view('login/login',$data);
		}
		//error_reporting(0);
	}
	
	/**
	* Load Branch List Page Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Branch
	* @since        16th June 2021
	* @deprecated   N/A
	**/
	
	public function index(){
		
		check_login();
		$data['branch'] = $this->CommonModel->RetriveRecordByWhere(TBL_BRANCH, array( 'status' => 1) );
		
		$data['meta_title'] = 'Branch List';
      	$data['meta_desc']  = 'Branch List Description';

		$data['content'] 	= 'branch/index';
		$this->load->view('layout_home', $data);
	}
	
	/**
	* Load Branch Add Page Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Branch
	* @since        16th June 2021
	* @deprecated   N/A
	**/
	
	public function add(){
		
		check_login();
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);
		
		$this->form_validation->set_rules('branch_name', 'branch name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('branch_code', 'branch code', 'required|trim|xss_clean');
		//$this->form_validation->set_rules('branch_code', 'branch code', 'trim|xss_clean|required|is_unique['.TBL_BRANCH.'.code]',array('is_unique' => 'This %s already exists.'));
		
		if (!$this->form_validation->run() === FALSE )
		{
			$InsertData = array(
				'branch' 		=> $data['branch_name'],
				'code' 			=> $data['branch_code'],
				'status' 		=> 1,
				'created_on' 	=> date('Y-m-d H:i:s'),
				'updated_on' 	=> date('Y-m-d H:i:s')
			);
			//echo "<pre>";print_r($InsertData);exit();
			
			$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_BRANCH);
			
			if( $lastInsertId !=''){
				$statusMsg 	= 'Branch details saved successfully.';
				$msgColor 	= 'success';
			}else{
				$statusMsg 	= 'Error occured while saving the branch.';
				$msgColor 	= 'error';
			}
			$this->session->set_flashdata($msgColor,$statusMsg);
			redirect(base_url('branch'));
			
		}else{
			$data['meta_title']	= 'Add branch';
			$data['meta_desc']	= 'Add branch Description';

			$data['content'] 	= 'branch/add';
			$this->load->view('layout_home', $data);
		}
	}
	
	/**
	* Load Branch Edit Page Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Branch
	* @since        16th June 2021
	* @deprecated   N/A
	**/
	
	public function edit($id){
		
		check_login();
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);
		
		/* if( $this->input->post('branch_code') != $this->input->post('hdn_code') ){
			$this->form_validation->set_rules('branch_code', 'branch code', 'trim|xss_clean|required|is_unique['.TBL_BRANCH.'.code]',array('is_unique' => 'This %s already exists.'));
		}else{ */
			$this->form_validation->set_rules('branch_name', 'branch name', 'required|trim|xss_clean');
			$this->form_validation->set_rules('branch_code', 'branch code', 'required|trim|xss_clean');
		//}
			
		if (!$this->form_validation->run() === FALSE )
		{
			$updateData = array(
				'branch' 		=> $data['branch_name'],
				'code' 			=> $data['branch_code'],
				'status' 		=> 1,
				'updated_on' 	=> date('Y-m-d H:i:s')
			);
			
			$result = $this->CommonModel->UpdateAllRecord($updateData,TBL_BRANCH, '_id', new MongoDB\BSON\ObjectId("$id") );
			
			if( $result == 1){
				$statusMsg 	= 'Branch details updated successfully.';
				$msgColor 	= 'success';
			}else{
				$statusMsg 	= 'Error occured while updatig the branch.';
				$msgColor 	= 'error';
			}
			$this->session->set_flashdata($msgColor,$statusMsg);
			redirect(base_url('branch'));
			
		}else{
			
			$data['EditData']	= $this->CommonModel->RetriveRecordByWhereRow(TBL_BRANCH,array('_id' => new MongoDB\BSON\ObjectId("$id")) );
			
			$data['meta_title']	= 'Edit Branch';
			$data['meta_desc']	= 'Edit Branch Description';

			$data['content'] 	= 'branch/edit';
			$this->load->view('layout_home', $data);
		}
	}
	
	/**
	* Load Branch Delete Page Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Branch
	* @since        16th June 2021
	* @deprecated   N/A
	**/
	
	public function delete($id){
		
		check_login();
		$set = array('status' => 0);
		$result = $this->CommonModel->Delete($set , TBL_BRANCH, new MongoDB\BSON\ObjectId("$id"), '_id');
		
		if( $result == 1){
			$statusMsg 	= 'Branch details deleted successfully.';
			$msgColor 	= 'success';
		}else{
			$statusMsg 	= 'Error occured while deleting the branch.';
			$msgColor 	= 'error';
		}
		
		$this->session->set_flashdata($msgColor,$statusMsg);
		redirect(base_url('branch'));
	}
	
}
?>