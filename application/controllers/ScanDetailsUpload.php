<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ScanDetailsUpload extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_login();
		error_reporting(0);
		date_default_timezone_set("Asia/Kolkata");
		require_once APPPATH."/third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel.php";
		require_once APPPATH."/third_party/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php";
	}
	
	/**
	* Load Scan Details Upload Method
	* 
	* @param1       
	* @return       view page
	* @access       public
	* @author       M.K.Sah
	* @copyright    N/A
	* @link         application/ScanDetailsUpload
	* @since        16th June 2021
	* @deprecated   N/A
	**/
	
	public function index(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['scan_details_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['scan_details_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow 	= $sheet->getHighestRow();
					$highestColumn 	= $sheet->getHighestColumn(); // e.g 'F'
					$totalColumNo 	= PHPExcel_Cell::columnIndexFromString($highestColumn);
					/* echo '$highestColumn - '.$highestColumn; echo "<br>";
					echo '$totalColumNo - '.$totalColumNo; exit; */
					
					//if( $highestColumn == 'O' && $totalColumNo == 15 ){
						
						$startRow = 1;
						for($row = $startRow; $row <= $getHighestRow; $row++){
							
							$scnaDate = $sheet->getCellByColumnAndRow(1,$row)->getFormattedValue();
							//$scnaDate = PHPExcel_Shared_Date::ExcelToPHP($scnaDate); //unix value
							
							$InsertData = array(
								'stock_take_no' => strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
								//'date' 		=> changeDateFormat($scnaDate),// date format changed.
								'date' 			=> changeDateFormat_2($scnaDate),
								'store_code'   	=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
								'artical_no'   	=> strval($sheet->getCellByColumnAndRow(3,$row)->getValue()),
								'ean'   		=> strval($sheet->getCellByColumnAndRow(4,$row)->getValue()),
								'product_desc'  => $sheet->getCellByColumnAndRow(5,$row)->getValue(),
								'location'   	=> strval($sheet->getCellByColumnAndRow(6,$row)->getValue()),
								// here row 7 is left as empty row as per the new excel sheet.
								'net_scan_qty'  => $sheet->getCellByColumnAndRow(8,$row)->getValue(),
								'valid_scan'   	=> $sheet->getCellByColumnAndRow(9,$row)->getValue(),
								'invalid_scan'  => $sheet->getCellByColumnAndRow(10,$row)->getValue(),
								'remarks'   	=> $sheet->getCellByColumnAndRow(11,$row)->getValue(),
								//'scanner_no'   	=> $sheet->getCellByColumnAndRow(12,$row)->getValue(),
								'user_id'   	=> $sheet->getCellByColumnAndRow(12,$row)->getValue(),
								'scanner_man_name'=> $sheet->getCellByColumnAndRow(13,$row)->getValue(),
								'gc_person_name'=> $sheet->getCellByColumnAndRow(14,$row)->getValue(),
								'created_on' 	=> date('Y-m-d')
							);
							
							//echo "<pre>";print_r($InsertData);exit();
							if( $scnaDate !='' ){
								$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_PHYSICAL_SCAN_DETAILS_REGISTER);
							}
						}
						
						if( $lastInsertId !=''){
							$statusMsg 	= 'Scan Details Uploaded successfully.';
							$msgColor 	= 'success';
						}else{
							$statusMsg 	= 'Error occured while uploading files.';
							$msgColor 	= 'error';
						}
						
						$this->session->set_flashdata($msgColor,$statusMsg);
						redirect(base_url('scan-details-upload'));
						exit();
						
					/* }else{
						$this->session->set_flashdata('error','Please upload excel sheet in the given format only.');
						redirect(base_url('scan-details-upload'));
						exit();
					} */
				}
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('scan-details-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'Scan Details Upload';
			$data['meta_desc']  = 'Scan Details Upload Description';
			
			$data['content'] 	= 'scan_item_upload/scan_details_upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	public function preStockUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['pre_stock_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['pre_stock_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow 	= $sheet->getHighestRow();
					$startRow = 1;
					
					for($row = $startRow; $row <= $getHighestRow; $row++){
						
						$rate 	= $sheet->getCellByColumnAndRow(4,$row)->getValue();
						$qty 	= $sheet->getCellByColumnAndRow(5,$row)->getValue();
						$value 	= round( $qty * $rate , 2, PHP_ROUND_HALF_UP);
						
						//****//
						$stockTakeNo 	= $sheet->getCellByColumnAndRow(0,$row)->getValue();
						$stockTakeNo 	= str_split($stockTakeNo);
						$storeCode 		= $stockTakeNo[0].$stockTakeNo[1].$stockTakeNo[2].$stockTakeNo[4];
						//****//
						
						$InsertData = array(
							'store_code' 	=> strval($storeCode),
							//'date' 			=> date('Y-m-d'),
							'stock_take_no' => strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
							'artical_no'   	=> strval($sheet->getCellByColumnAndRow(1,$row)->getValue()),
							'ean'   		=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
							'product_desc'  => $sheet->getCellByColumnAndRow(3,$row)->getValue(),
							'rate'   		=> $rate,
							'qty'  			=> $qty,
							'value'   		=> $value,
							'created_on' 	=> date('Y-m-d')
						);
						
						//echo "<pre>";print_r($InsertData);
						if( $InsertData['stock_take_no'] !='' ){
							$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_PRE_STOCK);
						}
					}
					//exit();
				}
				
				if( $lastInsertId !=''){
					$statusMsg 	= 'Pre Stock Uploaded successfully.';
					$msgColor 	= 'success';
				}else{
					$statusMsg 	= 'Error occured while uploading files.';
					$msgColor 	= 'error';
				}
				$this->session->set_flashdata($msgColor,$statusMsg);
				redirect(base_url('pre-stock-upload'));
				exit();
				
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('pre-stock-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'Pre Stock Upload';
			$data['meta_desc']  = 'Pre Stock Upload Description';
			
			$data['content'] 	= 'scan_item_upload/pre_stock_upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	
	public function locationMappingUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['location_mapping_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['location_mapping_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow = $sheet->getHighestRow();
					$startRow = 1;
					for($row = $startRow; $row <= $getHighestRow; $row++){
						
						$date = $sheet->getCellByColumnAndRow(1,$row)->getFormattedValue();
						
						$InsertData = array(
							'stock_take_no' => strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
							'date'   		=> date_format(date_create($date),'Y-m-d'),
							'store_code' 	=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
							'number'  		=> $sheet->getCellByColumnAndRow(3,$row)->getValue(),
							'shift'   		=> $sheet->getCellByColumnAndRow(4,$row)->getValue(),
							'start_location'=> $sheet->getCellByColumnAndRow(5,$row)->getValue(),
							'end_location' 	=> $sheet->getCellByColumnAndRow(6,$row)->getValue(),
							'created_on' 	=> date('Y-m-d')
						);
						
						//echo "<pre>";print_r($InsertData);
						if( $InsertData['stock_take_no'] !='' ){
							$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_LOCATION_MAPPING_UPLOAD);
						}
					}
					//exit();
				}
				
				if( $lastInsertId !=''){
					$statusMsg 	= 'Location Mapping Uploaded successfully.';
					$msgColor 	= 'success';
				}else{
					$statusMsg 	= 'Error occured while uploading files.';
					$msgColor 	= 'error';
				}
				$this->session->set_flashdata($msgColor,$statusMsg);
				redirect(base_url('location-mapping-upload'));
				exit();
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('location-mapping-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'Location Mapping Upload';
			$data['meta_desc']  = 'Location Mapping Upload Description';
			
			$data['content'] 	= 'scan_item_upload/location-mapping-upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	public function gcUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['user_details_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['user_details_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
					$totalColumNo = PHPExcel_Cell::columnIndexFromString($highestColumn);
					/* echo $highestColumn;
					echo $totalColumNo;exit(); */
					
					//if( $highestColumn == 'E' && $totalColumNo == 5 ){
						
						$startRow = 1;
						for($row = $startRow; $row <= $getHighestRow; $row++){
							
							$date = $sheet->getCellByColumnAndRow(0,$row)->getFormattedValue();
							
							$InsertData = array(
								'date' 			=> changeDateFormat_2($date),
								'stock_take_no' => strval($sheet->getCellByColumnAndRow(1,$row)->getValue()),
								'store_code' 	=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
								'ean'  			=> strval($sheet->getCellByColumnAndRow(3,$row)->getValue()),
								'quantity' 		=> $sheet->getCellByColumnAndRow(4,$row)->getValue(),
								'created_on' 	=> date('Y-m-d')
							);
							
//							 echo "<pre>";print_r($InsertData);exit;
							/*echo $row; */
							
							if( $InsertData['date'] !='' ){
								$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_GC_USER_DETAILS_UPLOAD);
							}
						}
						
						if( $lastInsertId !=''){
							$statusMsg 	= 'GC Details Uploaded successfully.';
							$msgColor 	= 'success';
						}else{
							$statusMsg 	= 'Error occured while uploading files.';
							$msgColor 	= 'error';
						}
						$this->session->set_flashdata($msgColor,$statusMsg);
						redirect(base_url('gc-upload'));
						exit();
						
					/* }else{
						$this->session->set_flashdata('error','Please upload excel sheet in the given format only.');
						redirect(base_url('user-details-upload'));
						exit();
					} */
					
				}
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('user-details-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'GC Details Upload';
			$data['meta_desc']  = 'GC Details Upload Description';
			
			$data['content'] 	= 'scan_item_upload/user_details_upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	public function itemMasterUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['item_master_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['item_master_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
					$totalColumNo = PHPExcel_Cell::columnIndexFromString($highestColumn);
					/* echo $highestColumn;
					echo $totalColumNo;exit(); */
					
					if( $highestColumn == 'D' && $totalColumNo == 4 ){
						
						$startRow = 1;
						for($row = $startRow; $row <= $getHighestRow; $row++){
							
							$InsertData = array(
								'stock_take_no' => strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
								'artical_no' 	=> strval($sheet->getCellByColumnAndRow(1,$row)->getValue()),
								'ean'  			=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
								'product_desc' 	=> $sheet->getCellByColumnAndRow(3,$row)->getValue(),
								'created_on' 	=> date('Y-m-d')
							);
							
							//echo "<pre>";print_r($InsertData);
							if( $InsertData['stock_take_no'] !='' ){
								$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_ITEM_MASTER);
							}
						}
						
						if( $lastInsertId !=''){
							$statusMsg 	= 'Item Master Uploaded successfully.';
							$msgColor 	= 'success';
						}else{
							$statusMsg 	= 'Error occured while uploading files.';
							$msgColor 	= 'error';
						}
						$this->session->set_flashdata($msgColor,$statusMsg);
						redirect(base_url('item-master-upload'));
						exit();
						
					}else{
						
						$this->session->set_flashdata('error','Please upload excel sheet in the given format only items.');
						redirect(base_url('variance-register-details-upload'));
						exit();
					}
				}
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('item-master-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'Item Master Upload';
			$data['meta_desc']  = 'Item Master Upload Description';
			
			$data['content'] 	= 'scan_item_upload/item_master_upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	public function varianceReportUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['variance_register_upload']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['variance_register_upload']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
					$totalColumNo = PHPExcel_Cell::columnIndexFromString($highestColumn);
					
					/* echo $highestColumn;
					echo $totalColumNo;exit(); */
					
					if( $highestColumn == 'L' && $totalColumNo == 12 ){
						
						$startRow = 1;
						for($row = $startRow; $row <= $getHighestRow; $row++){
						
							$InsertData = array(
								'ean' 			=> strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
								'artical_no' 	=> strval($sheet->getCellByColumnAndRow(1,$row)->getValue()),
								'product_desc' 	=> $sheet->getCellByColumnAndRow(2,$row)->getValue(),
								'rate' 			=> $sheet->getCellByColumnAndRow(3,$row)->getValue(),
								'pre_stock' 	=> $sheet->getCellByColumnAndRow(4,$row)->getValue(),
								'pre_stock_value' => $sheet->getCellByColumnAndRow(5,$row)->getValue(),
								'post_stock' 	=> $sheet->getCellByColumnAndRow(6,$row)->getValue(),
								'post_stock_value' 	=> $sheet->getCellByColumnAndRow(7,$row)->getValue(),
								'variance_qty' 	=> $sheet->getCellByColumnAndRow(8,$row)->getValue(),
								'variance_value' => $sheet->getCellByColumnAndRow(9,$row)->getValue(),
								'remarks' 		=> $sheet->getCellByColumnAndRow(10,$row)->getValue(),
								'created_on' 	=> date('Y-m-d')
							);
							
							if( $InsertData['ean'] !='' ){
								$lastInsertId = $this->CommonModel->AddRecord($InsertData,'tbl_variance_reconcilation_upload');
							}
						}
						
						if( $lastInsertId !=''){
							$statusMsg 	= 'Variance Rgister(Details) Uploaded successfully.';
							$msgColor 	= 'success';
						}else{
							$statusMsg 	= 'Error occured while uploading files.';
							$msgColor 	= 'error';
						}
						$this->session->set_flashdata($msgColor,$statusMsg);
						redirect(base_url('variance-register-details-upload'));
						exit();
						
					}else{
						
						$this->session->set_flashdata('error','Please upload excel sheet in given format.');
						redirect(base_url('variance-register-details-upload'));
						exit();
					}
				}
				
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('variance-register-details-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'Variance Rgister(Details) Upload';
			$data['meta_desc']  = 'Variance Rgister(Details) Upload Description';
			
			$data['content'] 	= 'scan_item_upload/variance_report_upload';
			$this->load->view('layout_home', $data);
		}
	}
	
	
	public function deleteScanItem(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		if( isset($param) && !empty($param)){
			
			/*********************** Search Conditions Starts ***********************/
			if( isset($param) && !empty($param) && $param['store_code']!='' && $param['from_date']!='' ){
				$store_code 	= $param['store_code'];
				$from_date 		= date('Y-m-d',strtotime($param['from_date']));
				$to_date 		= date('Y-m-d',strtotime($param['to_date']));
				$whereConditions = array( "store_code" => $store_code , "date" => array('$gte' => $from_date, '$lte' => $to_date) );
				$whereConditions_pre_stock = array( "store_code" => $store_code , "created_on" => array('$gte' => $from_date, '$lte' => $to_date) );
				$whereConditions_variance = array("created_on" => array('$gte' => $from_date, '$lte' => $to_date) );
				$deleteMsg = ' with store code '. $store_code. ' and date '.$from_date .' to '.$to_date;
			}
			/* else if( isset($param) && !empty($param) && $param['store_code']!='' && $param['to_date']!='' ){
				$store_code 	= $param['store_code'];
				$to_date 		= date('Y-m-d',strtotime($param['to_date']));
				$whereConditions = array( "store_code" => $store_code , "date" => $to_date );
			}else if(isset($param) && !empty($param) && $param['store_code']!='' ){
				$store_code = $param['store_code'];
				$whereConditions = array( "store_code" => $store_code );
				$deleteMsg = ' with store code '. $store_code;
			}else if( isset($param) && !empty($param) && $param['from_date']!='' ){
				$from_date = date('Y-m-d',strtotime($param['from_date']));
				$whereConditions = array( "date" => $from_date);
				$deleteMsg = ' uploaded on '. date('d-m-Y',strtotime($param['from_date']));
			}else if( isset($param) && !empty($param) && $param['to_date']!='' ){
				$to_date = date('Y-m-d',strtotime($param['to_date']));
				$whereConditions = array( "date" => $to_date);
				$deleteMsg = ' uploaded on '. date('d-m-Y',strtotime($param['to_date']));
			} */
			else{
				$whereConditions = array();
			}
			/*********************** Search Conditions Ends ***********************/
			
			$this->CommonModel->DeleteAllPermanently($whereConditions, TBL_USER_DETAILS);
			$this->CommonModel->DeleteAllPermanently($whereConditions, TBL_GC_USER_DETAILS_UPLOAD);
			$this->CommonModel->DeleteAllPermanently($whereConditions, TBL_LOCATION_MAPPING_UPLOAD);
			$this->CommonModel->DeleteAllPermanently($whereConditions_pre_stock, TBL_PRE_STOCK);
			$this->CommonModel->DeleteAllPermanently($whereConditions_variance, TBL_VARIANCE_RECONCILATION_UPLOAD);
			$this->CommonModel->DeleteAllPermanently($whereConditions, TBL_PHYSICAL_SCAN_DETAILS_REGISTER);
			
			if( isset($param) && $param['store_code']!='' ){
				$store_code 		= $param['store_code'];
				$whereConditions_2 	= array( "store_code" => $store_code );
				$this->CommonModel->DeleteAllPermanently($whereConditions_2, TBL_PRE_STOCK);
			}
			
			$this->session->set_flashdata('success','All GC DETAILS , SCAN DETAILS , USER DETAILS , LOCATION MAPPING and PRE STOCK '.$deleteMsg .' deleted successfully.');
			redirect(base_url('delete-scan-details-item'));
			exit();
		} 
		
		$data['meta_title'] = 'Delete Scan Details Upload Items';
		$data['meta_desc']  = 'Delete Scan Details Upload Items Description';
		
		$data['content'] 	= 'reports/delete_scan_item';
		$this->load->view('layout_home', $data);
	}
	
	
	public function deleteItemMaster(){
		
		$param = $this->input->get();
		$param = array_map('trim', $param);
		$param = $this->security->xss_clean($param);
		//echo "<pre>";print_r($param);exit();
		
		if( isset($param) && !empty($param)){
			$from_date 			= date('Y-m-d',strtotime($param['from_date']));
			$to_date 			= date('Y-m-d',strtotime($param['to_date']));
			$itemData = $this->CommonModel->RetriveRecordByWhere(TBL_ITEM_MASTER, array("created_on" => array('$gte' => $from_date, '$lte' => $to_date)));
			
			if( isset($itemData) && count($itemData) > 0){
				
				if( isset($param) && !empty($param) && $param['from_date']!='' ){
					$from_date 			= date('Y-m-d',strtotime($param['from_date']));
					$whereConditions 	= array( "created_on" =>array('$gte' => $from_date, '$lte' => $to_date));
				}else{
					$whereConditions = array();
				}
				$this->CommonModel->DeleteAllPermanently($whereConditions, TBL_ITEM_MASTER);
				
				$this->session->set_flashdata('success','Total no of '.count($itemData).' item master uploaded on '.date('d-m-Y',strtotime($this->input->get('from_date'))).' deleted successfully.');
				redirect(base_url('delete-item-master'));
				exit();
			}else{
				$this->session->set_flashdata('success','No item master found on '.date('d-m-Y',strtotime($this->input->get('from_date'))));
				redirect(base_url('delete-item-master'));
				exit();
			}
		}
		
		$data['meta_title'] = 'Delete Item Master';
		$data['meta_desc']  = 'Delete Item Master Description';
		
		$data['content'] 	= 'reports/delete_item_master';
		$this->load->view('layout_home', $data);
	}
	
	
	public function userDetailsUpload(){
		
		if( isset($_POST['submitBtn']) )
		{
			$exnt = pathinfo($_FILES['user_details']['name'] ,PATHINFO_EXTENSION);
			
			if( $exnt == 'xls' || $exnt == 'xlsx' ){
				$nameOfFile	= $_FILES['user_details']['tmp_name'];
				$obj 		= PHPExcel_IOFactory::load($nameOfFile);
				
				foreach($obj->getWorksheetIterator() as $sheet){
					
					$getHighestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
					$totalColumNo = PHPExcel_Cell::columnIndexFromString($highestColumn);
					
					/* echo '$highestColumn - '.$highestColumn.'<br>';
					echo '$totalColumNo - '.$totalColumNo;exit(); */
					
					//if( $highestColumn == 'Q' && $totalColumNo == 17 ){
						
						$startRow = 1;
						for($row = $startRow; $row <= $getHighestRow; $row++){
							
							$scnaDate = $sheet->getCellByColumnAndRow(4,$row)->getFormattedValue();
							
							//****//
							$locationNo 	= $sheet->getCellByColumnAndRow(2,$row)->getValue();
							$locationNo 	= str_split($locationNo);
							$location_no_only = $locationNo[13].$locationNo[14].$locationNo[15].$locationNo[16];
							//****//
							
							$InsertData = array(
								'stock_take_no' => strval($sheet->getCellByColumnAndRow(0,$row)->getValue()),
								'store_code'   	=> strval($sheet->getCellByColumnAndRow(1,$row)->getValue()),
								'location'   	=> strval($sheet->getCellByColumnAndRow(2,$row)->getValue()),
								'location_no_only' => strval($location_no_only),
								'gc_qty'   		=> $sheet->getCellByColumnAndRow(3,$row)->getValue(),
								'date' 			=> changeDateFormat_2($scnaDate),
								'valid_qty'   	=> $sheet->getCellByColumnAndRow(5,$row)->getValue(),
								'invalid_qty'  	=> $sheet->getCellByColumnAndRow(6,$row)->getValue(),
								'wbc_qty'  		=> $sheet->getCellByColumnAndRow(7,$row)->getValue(),
								'net_scan_qty'  => $sheet->getCellByColumnAndRow(8,$row)->getValue(),
								'axcess_qty'  	=> $sheet->getCellByColumnAndRow(9,$row)->getValue(),
								'short_qty'  	=> $sheet->getCellByColumnAndRow(10,$row)->getValue(),
								'remarks'  		=> $sheet->getCellByColumnAndRow(11,$row)->getValue(),
								'accuracy'  	=> $sheet->getCellByColumnAndRow(12,$row)->getValue(),
								'user_id'   	=> $sheet->getCellByColumnAndRow(13,$row)->getValue(),
								'scanner_man_name'=> $sheet->getCellByColumnAndRow(14,$row)->getValue(),
								'gc_person_name'=> $sheet->getCellByColumnAndRow(15,$row)->getValue(),
								'created_on' 	=> date('Y-m-d')
							);
							
							//echo "<pre>";print_r($InsertData);
							if( $InsertData['stock_take_no'] !='' ){
								$lastInsertId = $this->CommonModel->AddRecord($InsertData,TBL_USER_DETAILS);
							}
						}
						
						if( $lastInsertId !=''){
							$statusMsg 	= 'User Details Uploaded successfully.';
							$msgColor 	= 'success';
						}else{
							$statusMsg 	= 'Error occured while uploading files.';
							$msgColor 	= 'error';
						}
						$this->session->set_flashdata($msgColor,$statusMsg);
						redirect(base_url('user-details-upload'));
						exit();
						
					/* }else{
						$this->session->set_flashdata('error','Please upload excel sheet in the given format only.');
						redirect(base_url('user-details-upload'));
						exit();
					} */
				}
				
			}else{
				$this->session->set_flashdata('error','Invalied file type.');
				redirect(base_url('user-details-upload'));
				exit();
			}
	    }
	    else 
		{
			$data['meta_title'] = 'User Details Upload';
			$data['meta_desc']  = 'User Details Upload Description';
			
			$data['content'] 	= 'scan_item_upload/user_details';
			$this->load->view('layout_home', $data);
		}
	}

}
?>