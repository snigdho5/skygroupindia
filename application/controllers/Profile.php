<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->library('email');
		date_default_timezone_set("Asia/Kolkata");
		if( $this->session->userdata('user_login_session') != "true" && $this->session->userdata('user_id') =='' )
	    {
	      $data['meta_title'] = 'Product List';
	      $data['meta_desc']  = 'Product List Description';
	      $this->load->view('login/login',$data);
	    }
		//error_reporting(0);
    }
	
	public function change_password(){
		
		check_login();
		$formVal = $this->input->post();
		$formVal = array_map('trim', $formVal);
		$formVal = $this->security->xss_clean($formVal);
		
		$this->form_validation->set_rules('old_password', 'old password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'new password', 'required|trim');
		$this->form_validation->set_rules('cnf_new_password', 'confirm new password', 'required|matches[new_password]|trim');
		
		if (!$this->form_validation->run() === FALSE)
		{
			if ( $formVal['new_password'] != $formVal['cnf_new_password']) {
				$this->session->set_flashdata('error', 'New password and confirm new password did not match.');
				redirect(base_url('change-password'));
			}
			else
			{
				if( $this->CommonModel->do_password_change() == 'fail'){
					$this->session->set_flashdata('error', 'Incorrect password provided.');
					redirect(base_url('change-password'));
				}else{
					$this->session->set_flashdata('success', 'Password changed successfully.');
					redirect(base_url('change-password'));
				}
			}
		}
		
		$data['meta_title']	= 'Change Password';
		$data['meta_desc']	= 'Change Password Description';
		
		$data['content']  = 'login/change_password';
		$this->load->view('layout_home',$data);
	}
	
	public function user_profile(){
		
		$id = $this->session->userdata('user_db_id');
		
		$data = $this->input->post();
		$data = array_map('trim', $data);
		$data = $this->security->xss_clean($data);
		
		$this->form_validation->set_rules('user_full_name', 'user full name', 'required');
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
				  	@unlink($img_path);
				  	@unlink($thumb_img_path);
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
				//'email' 		=> $data['user_email'],
				'name' 			=> $data['user_full_name'],
				'gender'		=> $data['gender'],
				'phone' 		=> $data['phone_number'],
				'mobile' 		=> $data['mobile_number'],
				'street' 		=> $data['street_name'],
				'city' 			=> $data['city_town'],
				'state_id' 		=> $data['state_id'],
				'user_image' 	=> isset($user_image)?$user_image:'',   
				//'login_attempt' => 0,
				//'last_login' 	=> '0000-00-00 00:00:00',
				'ip_address'	=> getClientIP(),
				'updated_on' 	=> date('Y-m-d H:i:s')
			);
			
			$result = $this->CommonModel->UpdateAllRecord($updateData,TBL_USERS, '_id', new MongoDB\BSON\ObjectId("$id") );
			
			if( $result !=''){
				$statusMsg 	= 'Profile updated successfully.';
				$msgColor 	= 'success';
			}else{
				$statusMsg 	= 'Error occured while updating the user profile.';
				$msgColor 	= 'error';
			}
			$this->session->set_flashdata($msgColor,$statusMsg);
			redirect(base_url('profile'));
		}else{
			
			$data['branch'] 	= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_BRANCH, array( 'status' => 1),'branch', 'TRUE' );
			
			$data['userType'] 	= $this->CommonModel->RetriveRecordByNotEqualToIn('_id', new MongoDB\BSON\ObjectId('60cb913c438284b0a1bbc659'), TBL_GROUP);
			
			$data['states'] 	= $this->CommonModel->RetriveRecordByWhereOrderby(TBL_STATE, array('status' => 1),'state_name', 'TRUE');
			
			$data['EditData']	= $this->CommonModel->RetriveRecordByWhereRow(TBL_USERS,array('_id' => new MongoDB\BSON\ObjectId("$id")) );
			
			$data['meta_title']	= 'Edit Profile';
			$data['meta_desc']	= 'Edit Profile Description';
			$data['content']  	= 'users/edit_profile';
			$this->load->view('layout_home',$data);
		}
		
	}
	
	public function forgot_password(){
		
		$this->form_validation->set_rules('user_email', 'email', 'required');
		
		if (!$this->form_validation->run() === FALSE )
		{
			$checkUserExistance	= $this->CommonModel->RetriveRecordByWhereRow(TBL_USERS,array('email' => trim($this->input->post('user_email', TRUE))));
			
			if( isset($checkUserExistance) && count($checkUserExistance)>0 ){
				
				$id 	= $checkUserExistance[0]['_id'];
				$email 	= $checkUserExistance[0]['email'];
				$name 	= $checkUserExistance[0]['name'];
				$mobile = $checkUserExistance[0]['mobile'];
				
				$updateData = array(
					'password'		=> encriptPassword(12345),  
					'login_attempt' => 0,
					'last_login' 	=> '0000-00-00 00:00:00',
					'ip_address'	=> getClientIP(),
					'updated_on' 	=> date('Y-m-d H:i:s')
				);
				
				$this->CommonModel->UpdateAllRecord($updateData,TBL_USERS, '_id', new MongoDB\BSON\ObjectId("$id") );
				
				$config = Array(
					'protocol' 	=> 'smtp',
					'smtp_host' => '',// put your host.
					'smtp_port' => 465,
					'smtp_user' => '',// put your user id.
					'smtp_pass' => '',// put your pwd.
					'mailtype' 	=> 'html'
				);

				$this->email->initialize($config);

				$this->email->from('noreply@skygroupindia.com', 'Password Change Alert');
				$this->email->to($email);

				$this->email->subject('Password change alert.');

				$mailBody = '<body>
					<div style="width:650px; margin:50px auto; background:#024176; padding:20px 20px ">
					<table  width="100%" border="0"   bordercolor="#ccc" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="border-collapse:collapse;">
					<tr>
					</tr>
					<tr> 
					<td>&nbsp;&nbsp;
					<span style="color:#3a3a3a; font-weight:600;  font-size:12px; padding-top:10px; font-family:Verdana, Geneva, sans-serif;">Dear</span>
					<span style="color:#3a3a3a; font-weight:600;  font-size:12px; padding-top:10px; font-family:Verdana, Geneva, sans-serif;"> '.$name.' , </span><br />
					</td>
					</tr>
					<tr>
					<td colspan="5"><p style=" padding-top:8px;  font-family:Verdana, Geneva, sans-serif;  font-size:14px; color:#333; line-height:20px;">&nbsp;&nbsp;&nbsp;
						Your password is <strong>'.'12345'.'</strong> generated by system. Please login using this once and change your password as per your need.<br><br>
						</p>
					</td>
					</tr>
					
					</table>
					</div>
				</body>';
				
				$this->email->message($mailBody);

				if( $this->email->send() ){
					$this->session->set_flashdata('success','Please check your mail. An Email sent to '. $email .' with a system generated password.');
					redirect(base_url());
					exit();
				} else {
					$this->session->set_flashdata('error','Email sending fialed. Please try after some time.');
					redirect(base_url('forgot-password'));
					exit();
				}				
			}else{
				$this->session->set_flashdata('error','Email does not exists in the system.');
				redirect(base_url('forgot-password'));
				exit();
			}
		}else{
			$data['meta_title']	= 'Forgot Password';
			$data['meta_desc']	= 'Forgot Password Description';
			$this->load->view('users/forgot_password',$data);
		}		
	}
	
}
?>