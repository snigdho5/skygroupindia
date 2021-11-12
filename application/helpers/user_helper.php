<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* user helper page
* 
* @param1       
* @return       helper functions
* @access       public
* @author       M.K.Sah
* @copyright    N/A
* @link         application/helper
* @since        31 March 2021
* @deprecated   N/A
**/

function check_login() {
  $ci = & get_instance();
  if ($ci->session->userdata('user_login_session') == 1 && $ci->session->userdata('user_id') != '')
  {
    return "true";
  }else{
    redirect(base_url('login'));
  }
}

function getRowData($field,$userID,$table) {
	$ci = & get_instance();
	return $ci->mongo_db->where($field,$userID)->get($table);
}


function getPostStockByEanNo($eanNo,$table){
	$ci = & get_instance();
	
	$postStock = $ci->mongo_db->where( array( 'ean' => $eanNo ,'valid_scan' => 1) )->get($table);
	
	if( isset( $postStock ) && !empty($postStock) ){
		
		$netScanQty = 0;
		foreach($postStock as $val){
			$netScanQty += $val['net_scan_qty'];
			$result['net_scan_qty'] = $netScanQty;
			$result['remarks'] 		= $val['remarks'];
		}
		return $result;
		
	}else{
		$result['net_scan_qty'] = 0;
		$result['remarks'] 		= '';
		return $result;
	}
}


function get_encript_id($pass) {
  $id_encode = base64_encode($pass);
  return urlencode($id_encode);
}

function get_decript_id($pass) {
  $id_encode = urldecode($pass);
  return base64_decode($id_encode);
}

function encriptPassword($password){
	$md5_convert_data = md5(trim( $password ));
	$salt_key = get_encript_id(trim( $password ));
	$password = $md5_convert_data.$salt_key;
	return $password;
}

function getClientIP(){
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
    $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function changeDateFormat($date_form) // d-m-y to y-m-d  
{
	if ($date_form == '') {
		return $dateformat = '';
	} else if ($date_form == '0000-00-00') {
		return $dateformat = 'N/A';
	} else {
		$date1 	= explode("/", $date_form);
		
		$day 	= $date1[0];
		$month 	= $date1[1];
		$year 	= $date1[2];
		
		if($month < 10){
			$numlength = strlen((string)$month);
			if( $numlength >= 2){
				$month_no = $month;
			}else{
				$month_no = '0'.$month;
			}
		}else{
			$month_no = $month;
		}
		
		$dateformat = $year . "-" . $month_no . "-" . $day;
		return $dateformat;
	}
}


function changeDateFormat_2($date_form) // dd-mm-yyyy to yyyy-mm-dd  
{
	if ($date_form == '') {
		return $dateformat = '';
	} else if ($date_form == '0000-00-00') {
		return $dateformat = 'N/A';
	} else {
		$date1 	= explode("-", $date_form);
		//echo "<pre>";print_r($date1);exit();
		$day 	= $date1[1];
		$month 	= $date1[0];
		$year 	= $date1[2];
		
		if($month < 10){
			$numlength = strlen((string)$month);
			if( $numlength >= 2){
				$month_no = $month;
			}else{
				$month_no = '0'.$month;
			}
		}else{
			$month_no = $month;
		}
		
		//********//
		$addFirstTwoDigitsOfYear = date('Y');
		$addFirstTwoDigitsOfYear = substr($addFirstTwoDigitsOfYear, 0, 2);
		//********//
		
		$dateformat = $addFirstTwoDigitsOfYear.$year . "-" . $month_no . "-" . $day;
		return $dateformat;
	}
}

?>