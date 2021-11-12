<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __construct()
	{
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
	* Load Users List Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Users
	* @since        18th June 2021
	* @deprecated   N/A
	**/
	
	public function index(){
		
		check_login();
		$data['users'] 		= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_USERS, array('status' => 1),'name', 'TRUE');
		
		$data['meta_title'] = 'Users List';
      	$data['meta_desc']  = 'Users List Description';

		$data['content'] 	= 'users/index';
		$this->load->view('layout_home', $data);
	}
	
	/**
	* Load Users Add Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Users
	* @since        18th June 2021
	* @deprecated   N/A
	**/

	public function add(){
		
		check_login();
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);
		
		$this->form_validation->set_rules('branch_id', 'branch name', 'required');
		$this->form_validation->set_rules('user_email', 'user email', 'required');
		//$this->form_validation->set_rules('user_email', 'User email', 'required|valid_email|is_unique['.TBL_USERS.'.email]',array( 'is_unique' => '%s already exists.' ));
		
		$this->form_validation->set_rules('user_full_name', 'user full name', 'required');
		$this->form_validation->set_rules('user_type', 'user type', 'required');
		$this->form_validation->set_rules('gender', 'gender', 'required');
		$this->form_validation->set_rules('phone_number', 'phone number', 'required');
		$this->form_validation->set_rules('mobile_number', 'mobile number', 'required');
		$this->form_validation->set_rules('street_name', 'street name', 'required');
		$this->form_validation->set_rules('city_town', 'city/town', 'required');
		$this->form_validation->set_rules('state_id', 'state', 'required');
		
		/// Image Upload Satrts ///
		if(!empty($_FILES['user_image']['name']) )
		{
			$folder = FCPATH.'uploads/users_pic/';
			if(!file_exists($folder)){
				mkdir($folder, 0777, true);
			}
			$config['upload_path']   = './uploads/users_pic/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']      = '1072';  // (3MB * 1024KB) = 1072 KB Allowed.
			$config['max_width']     = '';
			$config['max_height']    = '';
			$config['file_name']     = 'image_'.time();

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( !$this->upload->do_upload('user_image') && isset($data) && !empty($data))
			{
				$data['image_error'] = $this->upload->display_errors();
			} else {
				@$img = array('uploaded_img' => $this->upload->data());
				$user_image = $img['uploaded_img']['file_name'];
				
				///////////////Image Resize Start///////////////////
				$folder = FCPATH.'uploads/users_pic/thumb/';
				if(!file_exists($folder)){
					mkdir($folder, 0777, true);
				}
				$this->load->library('image_lib');
				$config['image_library']  = 'gd2';
				$config['source_image']   = './uploads/users_pic/'.@$user_image;       
				$config['create_thumb']   = TRUE;
				$config['thumb_marker']   = "";
				$config['maintain_ratio'] = TRUE;
				$config['width']          = 250;
				$config['height']         = 250;
				$config['new_image']      = './uploads/users_pic/thumb/'.@$user_image;               
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize()) { 
					echo $this->image_lib->display_errors();
				}
				///////////////Image Resize End///////////////////
			}
		}
		/// Image Upload Ends ///
		
		if (!$this->form_validation->run() === FALSE )
		{
			$InsertData = array(
				'branch_id' 	=> $data['branch_id'],
				'email' 		=> $data['user_email'],
				'name' 			=> $data['user_full_name'],
				'user_type' 	=> $data['user_type'],
				'gender'		=> $data['gender'],
				'phone' 		=> $data['phone_number'],
				'mobile' 		=> $data['mobile_number'],
				'street' 		=> $data['street_name'],
				'city' 			=> $data['city_town'],
				'state_id' 		=> $data['state_id'],
				'status' 		=> isset($data['status'])?$data['status']:1,
				'user_image' 	=> isset($user_image)?$user_image:'',   
				'login_attempt' => 0,
				'last_login' 	=> '0000-00-00 00:00:00',
				'ip_address'	=> getClientIP(),
				'password'		=> encriptPassword(12345),
				'created_on' 	=> date('Y-m-d H:i:s'),
				'updated_on' 	=> date('Y-m-d H:i:s')
			);
			
			$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_USERS);
			if( $lastInsertId !=''){
				$statusMsg 	= 'User details saved successfully.';
				$msgColor 	= 'success';
			}else{
				$statusMsg 	= 'Error occured while saving the user details.';
				$msgColor 	= 'error';
			}
			$this->session->set_flashdata($msgColor,$statusMsg);
			redirect(base_url('user/add'));
		}else{
			
			$data['branch'] = $this->CommonModel->RetriveRecordByWhereOrderby(TBL_BRANCH, array( 'status' => 1),'branch', 'TRUE' );
			
			$data['userType'] 	= $this->CommonModel->RetriveRecordByNotEqualToIn('_id', new MongoDB\BSON\ObjectId('60cb913c438284b0a1bbc659'), TBL_GROUP);
			
			$data['states'] 	= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_STATE, array('status' => 1),'state_name', 'TRUE');
			
			$data['meta_title']	= 'Add User';
			$data['meta_desc']	= 'Add User Description';
			$data['content']  	= 'users/add';
			$this->load->view('layout_home',$data);
		}
	}
	
	public function edit($id){
		
		check_login();
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);
		
		$this->form_validation->set_rules('branch_id', 'branch name', 'required');
		$this->form_validation->set_rules('user_email', 'user email', 'required');
		$this->form_validation->set_rules('user_full_name', 'user full name', 'required');
		$this->form_validation->set_rules('user_type', 'user type', 'required');
		$this->form_validation->set_rules('gender', 'gender', 'required');
		$this->form_validation->set_rules('phone_number', 'phone number', 'required');
		$this->form_validation->set_rules('mobile_number', 'mobile number', 'required');
		$this->form_validation->set_rules('street_name', 'street name', 'required');
		$this->form_validation->set_rules('city_town', 'city/town', 'required');
		$this->form_validation->set_rules('state_id', 'state', 'required');
		
		/// Image Upload Satrts ///
		if(!empty($_FILES['user_image']['name']) )
		{
			$folder = FCPATH.'uploads/users_pic/';
			if(!file_exists($folder)){
				mkdir($folder, 0777, true);
			}
			$config['upload_path']   = './uploads/users_pic/';
			$config['allowed_types'] = 'jpeg|jpg|png';
			$config['max_size']      = '1072';  // (3MB * 1024KB) = 1072 KB Allowed.
			$config['max_width']     = '';
			$config['max_height']    = '';
			$config['file_name']     = 'image_'.time();

			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if ( !$this->upload->do_upload('user_image') && isset($data) && !empty($data))
			{
				$data['image_error'] = $this->upload->display_errors();
			} else {
				@$img = array('uploaded_img' => $this->upload->data());
				$user_image = $img['uploaded_img']['file_name'];
				
				$img_path = FCPATH.'uploads/users_pic/'.$this->security->xss_clean($this->input->post('hdn_user_img'));
				$thumb_img_path = FCPATH.'uploads/users_pic/thumb/'.$this->security->xss_clean($this->input->post('hdn_user_img'));

				if( isset($img) && $user_image != '' ){
				  	unlink($img_path);
				  	unlink($thumb_img_path);
				}
				
				///////////////Image Resize Start///////////////////
				$folder = FCPATH.'uploads/users_pic/thumb/';
				if(!file_exists($folder)){
					mkdir($folder, 0777, true);
				}
				$this->load->library('image_lib');
				$config['image_library']  = 'gd2';
				$config['source_image']   = './uploads/users_pic/'.@$user_image;       
				$config['create_thumb']   = TRUE;
				$config['thumb_marker']   = "";
				$config['maintain_ratio'] = TRUE;
				$config['width']          = 250;
				$config['height']         = 250;
				$config['new_image']      = './uploads/users_pic/thumb/'.@$user_image;               
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize()) { 
					echo $this->image_lib->display_errors();
				}
				///////////////Image Resize End///////////////////
			}
		}else{
			$user_image = $this->security->xss_clean(trim($this->input->post('hdn_user_img')));
		}
		/// Image Upload Ends ///
		
		if (!$this->form_validation->run() === FALSE )
		{
			$updateData = array(
				'branch_id' 	=> $data['branch_id'],
				'email' 		=> $data['user_email'],
				'name' 			=> $data['user_full_name'],
				'user_type' 	=> $data['user_type'],
				'gender'		=> $data['gender'],
				'phone' 		=> $data['phone_number'],
				'mobile' 		=> $data['mobile_number'],
				'street' 		=> $data['street_name'],
				'city' 			=> $data['city_town'],
				'state_id' 		=> $data['state_id'],
				'status' 		=> isset($data['status'])?$data['status']:1,
				'user_image' 	=> isset($user_image)?$user_image:'',   
				'login_attempt' => 0,
				'last_login' 	=> '0000-00-00 00:00:00',
				'ip_address'	=> getClientIP(),
				//'password'		=> encriptPassword(12345),
				//'created_on' 	=> date('Y-m-d H:i:s'),
				'updated_on' 	=> date('Y-m-d H:i:s')
			);
			
			$result = $this->CommonModel->UpdateAllRecord($updateData,TBL_USERS, '_id', new MongoDB\BSON\ObjectId("$id") );
			
			if( $result !=''){
				$statusMsg 	= 'User details updated successfully.';
				$msgColor 	= 'success';
			}else{
				$statusMsg 	= 'Error occured while updating the user details.';
				$msgColor 	= 'error';
			}
			$this->session->set_flashdata($msgColor,$statusMsg);
			redirect(base_url('user'));
		}else{
			
			$data['branch'] 	= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_BRANCH, array( 'status' => 1),'branch', 'TRUE' );
			
			$data['userType'] 	= $this->CommonModel->RetriveRecordByNotEqualToIn('_id', new MongoDB\BSON\ObjectId('60cb913c438284b0a1bbc659'), TBL_GROUP);
			
			$data['states'] 	= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_STATE, array('status' => 1),'state_name', 'TRUE');
			
			$data['EditData']	= $this->CommonModel->RetriveRecordByWhereRow(TBL_USERS,array('_id' => new MongoDB\BSON\ObjectId("$id")) );
			
			$data['meta_title']	= 'Edit User';
			$data['meta_desc']	= 'Edit User Description';
			$data['content']  	= 'users/edit';
			$this->load->view('layout_home',$data);
		}
	}
	
	
	/**
	* Load Users Delete Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Users
	* @since        18th June 2021
	* @deprecated   N/A
	**/
	
	public function delete($id){
		
		check_login();
		$set = array('status' => 0);
		$result = $this->CommonModel->Delete($set , TBL_USERS, new MongoDB\BSON\ObjectId("$id"), '_id');
		
		//$result = $this->mongo_db->where('_id', new MongoDB\BSON\ObjectId("$id"))->delete(TBL_USERS);
		
		if( $result == 1 ){
			$statusMsg 	= 'User details deleted successfully.';
			$msgColor 	= 'success';
		}else{
			$statusMsg 	= 'Error occured while deleting the user.';
			$msgColor 	= 'error';
		}
		
		$this->session->set_flashdata($msgColor,$statusMsg);
		redirect(base_url('users'));
	}
}