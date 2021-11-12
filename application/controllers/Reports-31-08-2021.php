<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	function __construct(){
		parent::__construct();
		require('vendor/autoload.php');
		date_default_timezone_set("Asia/Kolkata");
		check_login();
		//error_reporting(0);
	}
	
	/**
	* Load Scan Details Upload Reports Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/Reports
	* @since        28th June 2021
	* @deprecated   N/A
	**/
	
	public function index(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['store_code']!='' && $param['from_date']!='' ){
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code , "date" => $from_date );
			$whereConditions = array( "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['store_code']!='' && $param['to_date']!='' ){
			$store_code 	= $param['store_code'];
			$to_date 		= date('Y-m-d',strtotime($param['to_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code , "date" => $to_date );
			$whereConditions = array( "store_code" => $store_code , "date" => $to_date );
		}
		else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code );
			$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $from_date);
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $to_date);
			$whereConditions = array( "date" => $to_date);
		}else{
			//$whereConditions = array("invalid_scan" => 0, "valid_scan" => 1 );
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['scanDetailsReport'] = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		
		$data['meta_title'] = 'Scan Details Upload Reports';
		$data['meta_desc']  = 'Scan Details Upload Reports Description';
		
		$data['content'] 	= 'reports/scan_details_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function invalidEANreport(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['ean']!='' && $param['store_code']!='' && $param['from_date']!='' ){
			$ean 			= $param['ean'];
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "ean" => $ean , "store_code" => $store_code , "date" => $from_date );
			//$whereConditions = array( "ean" => $ean , "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' && $param['store_code']!='' && $param['to_date']!='' ){
			$ean 		= $param['ean'];
			$store_code = $param['store_code'];
			$to_date 	= date('Y-m-d',strtotime($param['to_date']));
			
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "ean" => $ean , "store_code" => $store_code , "date" => $to_date );
			//$whereConditions = array( "ean" => $ean , "store_code" => $store_code , "date" => $to_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' ){
			$ean = $param['ean'];
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "ean" => $ean);
			//$whereConditions = array( "ean" => $ean);
		}else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "store_code" => $store_code );
			//$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "date" => $from_date);
			//$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "valid_scan" => 0 , "invalid_scan" => 1, "date" => $to_date);
			//$whereConditions = array( "date" => $to_date);
		}else{
			$whereConditions = array("invalid_scan" => 1, "valid_scan" => 0 );
			//$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['invalidEanReport'] 	= $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		
		$data['meta_title'] = 'Invalid EAN Reports';
		$data['meta_desc']  = 'Invalid EAN Reports Description';
		
		$data['content'] 	= 'reports/invalid_ean_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function validEANreport(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r();exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['ean']!='' && $param['store_code']!='' && $param['from_date']!='' ){
			$ean 			= $param['ean'];
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "ean" => $ean , "store_code" => $store_code , "date" => $from_date );
			//$whereConditions = array( "ean" => $ean , "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' && $param['store_code']!='' && $param['to_date']!='' ){
			$ean 		= $param['ean'];
			$store_code = $param['store_code'];
			$to_date 	= date('Y-m-d',strtotime($param['to_date']));
			
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "ean" => $ean , "store_code" => $store_code , "date" => $to_date );
			//$whereConditions = array( "ean" => $ean , "store_code" => $store_code , "date" => $to_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' ){
			$ean = $param['ean'];
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "ean" => $ean);
			//$whereConditions = array( "ean" => $ean);
		}else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code );
			//$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $from_date);
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $to_date);
			//$whereConditions = array( "date" => $to_date);
		}else{
			$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0 );
			//$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['validEanReport'] = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		
		$data['meta_title'] = 'Valid EAN Reports';
		$data['meta_desc']  = 'Valid EAN Reports Description';
		
		$data['content'] 	= 'reports/valid_ean_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function withoutBarCodeReport(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['store_code']!='' && $param['from_date']!='' ){
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code , "date" => $from_date );
			$whereConditions = array("store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['store_code']!='' && $param['to_date']!='' ){
			$store_code 	= $param['store_code'];
			$to_date 		= date('Y-m-d',strtotime($param['to_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code , "date" => $to_date );
			$whereConditions = array("store_code" => $store_code , "date" => $to_date );
		}
		else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code );
			$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $from_date);
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			//$whereConditions = a//rray( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $to_date);
			$whereConditions = array("date" => $to_date);
		}else{
			//$whereConditions = array("invalid_scan" => 0, "valid_scan" => 1 );
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		//$data['bwcReport'] = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		$data['bwcReport'] = $this->CommonModel->RetriveRecordByWhere(TBL_USER_DETAILS, $whereConditions);
		
		$data['meta_title'] = 'Without Barcode(WBC) Report';
		$data['meta_desc']  = 'Without Barcode(WBC) Report Description';
		
		$data['content'] 	= 'reports/without_bar_code_count_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function locationWiseUserDetailsReport(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['store_code']!='' && $param['from_date']!='' ){
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['store_code']!='' && $param['to_date']!='' ){
			$store_code 	= $param['store_code'];
			$to_date 		= date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "store_code" => $store_code , "date" => $to_date );
		}
		else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "date" => $to_date);
		}else{
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['loctionWiseUserDetails'] = $this->CommonModel->RetriveRecordByWhere(TBL_USER_DETAILS, $whereConditions);
		//$data['loctionWiseUserDetails'] = $this->CommonModel->LocationWiseUserDetailsReoprt($param);
		
		$data['meta_title'] = 'Location Wise User Details Report';
		$data['meta_desc']  = 'Location Wise User Details Report Description';
		
		$data['content'] 	= 'reports/location_wise_user_details_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function varianceRegisterReport(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['ean']!='' && $param['from_date']!='' ){
			$ean 		= $param['ean'];
			$from_date 	= date('Y-m-d',strtotime($param['from_date']));
			
			$whereConditions = array( "ean" => $ean , "created_on" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' && $param['to_date']!='' ){
			$ean 		= $param['ean'];
			$to_date 	= date('Y-m-d',strtotime($param['to_date']));
			
			$whereConditions = array( "ean" => $ean , "created_on" => $to_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' ){
			$ean = $param['ean'];
			$whereConditions = array( "ean" => $ean);
		}
		else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "created_on" => $from_date);
		}
		else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "created_on" => $to_date);
		}
		else{
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['varianceReport'] = $this->CommonModel->RetriveRecordByWhere(TBL_PRE_STOCK, $whereConditions);
		
		$data['meta_title'] = 'Variance Register Reports';
		$data['meta_desc']  = 'Variance Register Reports Description';
		
		$data['content'] 	= 'reports/variance_register_report';
		$this->load->view('layout_home', $data);
	}
	
	public function delete_variance_record($id){
		
		$result = $this->CommonModel->DeletePermanently('_id', new MongoDB\BSON\ObjectId("$id") , TBL_PRE_STOCK );
		
		if( $result == 1){
			$statusMsg 	= 'One record deleted successfully.';
			$msgColor 	= 'success';
		}else{
			$statusMsg 	= 'Error occured while deleting the record.';
			$msgColor 	= 'error';
		}
		
		$this->session->set_flashdata($msgColor,$statusMsg);
		redirect(base_url('variance-register-report'));
	}
	
	
	public function varianceReconcilationReport(){
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['ean']!='' && $param['from_date']!='' ){
			$ean 		= $param['ean'];
			$from_date 	= date('Y-m-d',strtotime($param['from_date']));
			
			$whereConditions = array( "ean" => $ean , "created_on" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' && $param['to_date']!='' ){
			$ean 		= $param['ean'];
			$to_date 	= date('Y-m-d',strtotime($param['to_date']));
			
			$whereConditions = array( "ean" => $ean , "created_on" => $to_date );
		}
		else if( isset($param) && !empty($param) && $param['ean']!='' ){
			$ean = $param['ean'];
			$whereConditions = array( "ean" => $ean);
		}
		else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "created_on" => $from_date);
		}
		else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "created_on" => $to_date);
		}
		else{
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['varianceReconcilation'] = $this->CommonModel->RetriveRecordByWhere('tbl_variance_reconcilation_upload', $whereConditions);
		
		$data['meta_title'] = 'Variance Reconcilation Reports';
		$data['meta_desc']  = 'Variance Reconcilation Reports Description';
		$data['content'] 	= 'reports/variance_reconcilation_report';
		$this->load->view('layout_home', $data);
	}
	
	
	public function delete_variance_reconcilation_record($id){
		
		$result = $this->CommonModel->DeletePermanently('_id', new MongoDB\BSON\ObjectId("$id") ,'tbl_variance_reconcilation_upload');
		
		if( $result == 1){
			$statusMsg 	= 'One record deleted successfully.';
			$msgColor 	= 'success';
		}else{
			$statusMsg 	= 'Error occured while deleting the record.';
			$msgColor 	= 'error';
		}
		
		$this->session->set_flashdata($msgColor,$statusMsg);
		redirect(base_url('variance-reconcilation-report'));
	}
	
	
	public function locationWisePrint(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r();exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['stock_take_no']!='' && $param['store_code']!='' && $param['from_date']!='' ){
			$stock_take_no 	= $param['stock_take_no'];
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "stock_take_no" => $stock_take_no , "store_code" => $store_code , "date" => $from_date );
			$whereConditions = array( "stock_take_no" => $stock_take_no , "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['stock_take_no']!='' && $param['store_code']!='' && $param['to_date']!='' ){
			$stock_take_no 	= $param['stock_take_no'];
			$store_code 	= $param['store_code'];
			$to_date 		= date('Y-m-d',strtotime($param['to_date']));
			
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "stock_take_no" => $stock_take_no , "store_code" => $store_code , "date" => $to_date );
			$whereConditions = array( "stock_take_no" => $stock_take_no , "store_code" => $store_code , "date" => $to_date );
		}
		else if( isset($param) && !empty($param) && $param['stock_take_no']!='' ){
			$stock_take_no = $param['stock_take_no'];
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "stock_take_no" => $stock_take_no);
			$whereConditions = array( "stock_take_no" => $stock_take_no);
		}else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "store_code" => $store_code );
			$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $from_date);
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			//$whereConditions = array( "valid_scan" => 1 , "invalid_scan" => 0, "date" => $to_date);
			$whereConditions = array( "date" => $to_date);
		}else{
			//$whereConditions = array("invalid_scan" => 0, "valid_scan" => 1 );
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['locationWisePrint'] = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		
		$data['meta_title'] = 'Location Wise Print';
		$data['meta_desc']  = 'Location Wise Print Description';
		
		$data['content'] 	= 'reports/location_wise_print';
		$this->load->view('layout_home', $data);
	}
	
	
	public function locationWisePrintDetails(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r();exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['location']!='' ){
			$whereConditions = array("location" => $param['location']);
		}else{
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/
		
		$data['locationWisePrintDetails'] = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, $whereConditions);
		//db.tbl_physical_scan_details_register.aggregate([{ $group : { _id : '$location'} }]).pretty()
		
		/* $data['locationWisePrintDetails'] = $this->mongo_db->aggregate(
			'tbl_physical_scan_details_register',
			[
				[
					'$group' => ['_id' => '$location']
				]
			],
			[
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
		); */
		//echo "<pre>";print_r($data['locationWisePrintDetails']);exit();
		
		$data['meta_title'] = 'Location Wise Print Details';
		$data['meta_desc']  = 'Location Wise Print Details Description';
		
		$data['content'] 	= 'reports/location_wise_print_details';
		$this->load->view('layout_home', $data);
	}
	
	
	public function pdf_preview($locationNo){
		
		$details = $this->CommonModel->RetriveRecordByWhere(TBL_PHYSICAL_SCAN_DETAILS_REGISTER, array("location" => $locationNo));
		$detailsDate = isset($details[0]['date'])?date('d-m-Y',strtotime($details[0]['date'])):'';
		
		$logo = base_url().'images/logo.png';
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<title>Untitled Document</title>
					<style>
						@page  
						{ margin: 20px;
						} 
					</style>
				</head>
				<body>
					<table width="770" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; border-left:solid 1px #000; border-top:solid 1px #000;">
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="3">
									<tr>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><img src="'.$logo.'" alt="Sky Grou India" width="100" height="100"/></td>
									</tr>
									<tr>
										<td align="center" style="font-size:24px; font-weight:bold;  border-right:solid 1px #000; border-bottom: solid 1px #000;">Location-Wise Scan Printout</td>
									</tr>
									<tr>
										<td align="left" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>Date:</strong> '.$detailsDate.' </td>
									</tr>
									<tr>
										<td align="left" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>Location No:</strong> '.$locationNo.' </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="3">
									<tr>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>SL<br />
											No</strong>
										</td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>EAN</strong></td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>Product Description</strong></td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>Scan<br />Qty</strong></td>
									</tr>';
									
									$i = 0;
									$net_scan_qty = '';
									foreach($details as $value){
										$i++;
										$net_scan_qty += $value['net_scan_qty'];
									
									$html .='
									<tr>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">'.$i.'</td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">'.$value['ean'].'</td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">'.$value['product_desc'].'</td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">'.$value['net_scan_qty'].'</td>
									</tr>';
									
									}
									
									$html .='<tr>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">&nbsp;</td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;">&nbsp;</td>
										<td align="left" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>Total</strong></td>
										<td align="center" style="border-right:solid 1px #000; border-bottom:solid 1px #000;"><strong>'.$net_scan_qty.'</strong></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</body>
			</html>';
		
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$file='media/'.time().'.pdf';
		$mpdf->output($file,'I');
	}
	
	
	public function missing_location(){
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		/*********************** Search Conditions Starts ***********************/
		if( isset($param) && !empty($param) && $param['store_code']!='' && $param['from_date']!='' ){
			$store_code 	= $param['store_code'];
			$from_date 		= date('Y-m-d',strtotime($param['from_date']));
			
			$whereConditions = array( "store_code" => $store_code , "date" => $from_date );
		}
		else if( isset($param) && !empty($param) && $param['store_code']!='' && $param['to_date']!='' ){
			$store_code 	= $param['store_code'];
			$to_date 		= date('Y-m-d',strtotime($param['to_date']));
			
			$whereConditions = array( "store_code" => $store_code , "date" => $to_date );
		}
		else if(isset($param) && !empty($param) && $param['store_code']!='' ){
			$store_code = $param['store_code'];
			$whereConditions = array( "store_code" => $store_code );
		}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
			$from_date = date('Y-m-d',strtotime($param['from_date']));
			$whereConditions = array( "date" => $from_date);
		}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
			$to_date = date('Y-m-d',strtotime($param['to_date']));
			$whereConditions = array( "date" => $to_date);
		}else{
			$whereConditions = array();
		}
		//print_r($whereConditions);
		/*********************** Search Conditions Ends ***********************/

		//$this->mongo_db->where(['location_no_only' => $this->mongo_db->not($this->mongo_db->in([$fieldVal]))])->get(TBL_USER_DETAILS);
		
		/* $mappingLocation 	= $this->mongo_db->get('tbl_location_mapping_upload');
		$start_location 	= $mappingLocation[0]['start_location'];
		$end_location 		= $mappingLocation[0]['end_location'];
		
		$inCondition = array($start_location,$end_location);
		$data['missingLocation'] = $this->CommonModel->RetriveRecordByNotEqualToIn('location_no_only', $inCondition, TBL_USER_DETAILS); */
		
		$data['missingLocation'] = $this->CommonModel->RetriveRecordByWhere(TBL_USER_DETAILS, $whereConditions);
		
		$data['meta_title'] = 'Missing Location Reports';
		$data['meta_desc']  = 'Missing Location Reports Description';
		
		$data['content'] 	= 'reports/missing_location_report';
		$this->load->view('layout_home', $data);
	}
	
}
?>