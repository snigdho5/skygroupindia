<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description: Common class to reuse database query
 * Requirements: PHP5 or above and Mongodb 4.4.6
 * Auther: Manoj Kumar Sah
 * 
 * Class CommonModel
 **/

class CommonModel extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
	}

	/**
	 * RetriveRecordByWhere
	 *
	 * Will return all row of provided table as array with provided where clause (optional).
	 * 
	 * @param string $table
	 * @param array $where_clause
	 * @return array
	 */

	public function RetriveRecordByWhere($table, $where_clause)
	{
		if (!empty($where_clause)){
			$this->mongo_db->where($where_clause);
                }
		$result = $this->mongo_db->get($table);
//		echo $this->mongo_db->last_query();die;
		return $result;
	}
       function getPostStockByEanNo($eanNo,$table){
	
	$postStock = $this->mongo_db->where( array( 'ean' => $eanNo ,'valid_scan' => 1) )->get($table);
	
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
	public function RetriveRecordByWhere_missing_location($table, $where_clause)
	{
          
		if (!empty($where_clause)){
			$this->mongo_db->where($where_clause);
                }
		$result = $this->mongo_db->get($table);               
		return $result;
	}
	public function RetriveRecordByWhere_not_in($table, $where_clause)
	{
		if (!empty($where_clause)){
			$this->mongo_db->where($where_clause);
                }
		$result = $this->mongo_db->get($table);               
		return $result;
	}

	public function RetriveRecordByWhere_test($table, $where_clause)
	{
		if (!empty($where_clause))
			$this->mongo_db->where($where_clause);
		$aggregate = [];
		$aggregate[] = [
			'$group' => [
				'_id' => [
					'location' => '$location',
				],
			],
		];
		$this->mongo_db->aggregate($aggregate);

		$result = $this->mongo_db->get($table);
		//echo $this->mongo_db->last_query();die;
		return $result;
	}
	public function RetriveRecordByWheregroupby_invalid($table, $where_clause)
	{
 
		$group = [
			'$group' => [
				'_id'=>[
                                        "ean" => '$ean',
                                    "location" => '$location'
                                     ],
                                        "ean" => ['$first'=>'$ean'],
                                        "artical_no" => ['$first'=>'$artical_no'],
                                        "product_desc" => ['$first'=>'$product_desc'],
                                        "stock_take_no" => ['$first'=>'$stock_take_no'],
                                        "date" => ['$first'=>'$date'],
                                        "store_code" => ['$first'=>'$store_code'],
                                        "location" => ['$first'=>'$location'],
                                        "artical_no" => ['$first'=>'$artical_no'],
                                        "product_desc" => ['$first'=>'$product_desc'],                                        
                                        "remarks" => ['$first'=>'$remarks'],
                                        "user_id" => ['$first'=>'$user_id'],
                                        "scanner_man_name" => ['$first'=>'$scanner_man_name'],
                                        "gc_person_name" => ['$first'=>'$gc_person_name'],        
                                        "net_scan_qty" => ['$first'=>'$net_scan_qty'],        
                             "invalid_scan"=> ['$sum' => '$invalid_scan'],
                        ],
                ];
//                $aa[]=$where_clause;
		$result=$this->mongo_db->aggregate($table,[$where_clause,$group],                     
                        [
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
                        );

		return $result;
	}

public function RetriveRecordByWhere_in($table,$location){
    $where[]= ['$match'=>[
             "location"=> ['$in'=>  [$location]
         ]
        ]
];
    $result=$this->mongo_db->aggregate($table,$where,                     
                        [
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
                        );
    return $result;
}

public function RetriveRecordByWhere_missing_not_in($table,$stock_take_no,$whereCond){       
   $from_date=$whereCond['from_date'];
   $to_date=$whereCond['to_date'];
  //$stock=implode(",",$stock_take_no);
    $where= ['$match'=>[
            "date"=>['$gte'=>$from_date,'$lte'=>$to_date],
             "stock_take_no"=>['$nin'=>$stock_take_no]
        ]
];
   
    $result=$this->mongo_db->aggregate($table,[$where],                     
                        [
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
                        );
    return $result;
}
public function RetriveRecordByWhere_location_print($table,$whereConditions){
         $group=['$group' => [
        '_id'=>
              [
                  "location" => '$location',
                  "stock_take_no" => '$stock_take_no',
                  "date" => '$date',
                  "store_code" => '$store_code'
                  ],
        "total"=> ['$sum' => '$invalid_scan'],
    ]
   
                   
];
     
    $result=$this->mongo_db->aggregate($table,[$whereConditions,$group],                 
                        [
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
                        );
    return $result;
}
public function RetriveRecordBygroupcount($table,$condname,$cond){
      $group=['$group' => [
        '_id'=>
              [
                  "$condname" => "'".$cond."'"                
                  ],
        "total"=> ['$sum' => 1],
    ]
   
                   
];
   
    $result=$this->mongo_db->aggregate($table,[$group],                 
                        [
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
                        );
    return $result;
}
	public function RetriveRecordByWhere2($table_name, $where_clause)
	{
		$this->mongo_db->select(array('*'));
		if (!empty($where_clause))
			$this->mongo_db->where($where_clause);
		$query = $this->mongo_db->get('tbl_user_details');
		//print_r($query);die;
		return $query;
	}


	public function LocationWiseUserDetailsReoprt($param)
	{

		/* if(!empty($param) && $param['store_code']!='')
		$this->mongo_db->where('store_code',$param['store_code']);
		$result = $this->mongo_db->get(TBL_PHYSICAL_SCAN_DETAILS_REGISTER);
		return $result; */

		$result = $this->mongo_db->aggregate(
			'tbl_physical_scan_details_register',
			[
				[
					'$lookup' => [
						'from' 			=> "tbl_gc_user_details_upload",
						'localField'  	=> "stock_take_no",
						'foreignField' 	=> "stock_take_no",
						'as' 			=> "location_wise_user",
					],
					'$group' => [
						'_id' => [
							'location' => '$location'
						],
					],
				]
			],
			[
				'allowDiskUse' => TRUE,
				'cursor' => ['batchSize' => 0]
			]
		);
		return $result;

		/* db.tbl_physical_scan_details_register.aggregate([{
			$lookup:{
					from:"tbl_gc_user_details_upload",
					localField:"stock_take_no",
					foreignField: "stock_take_no",
					as:"location_wise_user"
				}
		}]).pretty(); */
	}

	/**
	 * RetriveRecordByWhereRow
	 *
	 * Will return single row of provided table as array with provided where clause (optional) .
	 * 
	 * @param string $table
	 * @param array $where_clause
	 * @return array
	 */

	public function RetriveRecordByWhereRow($table, $where_clause)
	{

		if (!empty($where_clause))
			$this->mongo_db->where($where_clause);
		return $this->mongo_db->getOne($table);
	}

	/**
	 * AddRecord
	 *
	 * Add provided records to provided table.
	 * 
	 * @param string $table
	 * @param array $row
	 * @return int
	 */

	function AddRecord($row, $table)
	{

		$lastInsertId = $this->mongo_db->insert($table, $row);
		return $lastInsertId;
	}

	/**
	 * UpdateRecord
	 *
	 * Update provided records to provided table With provided condition.
	 * 
	 * @param string $table
	 * @param array $row
	 * @param string $idfld
	 * @param string $id
	 * @return int
	 */

	function UpdateAllRecord($row, $table, $idfld, $id)
	{
		$this->mongo_db->set($row)->where($idfld, $id);
		$result = $this->mongo_db->updateAll($table);
		return $result;
	}

	/**
	 * Delete
	 *
	 * Delete single records of provided table With provided condition.
	 * 
	 * @param string $table
	 * @param string $id
	 * @param string $idfld
	 * @return int
	 */

	public function Delete($row, $table, $id, $idfld)
	{

		$this->mongo_db->set($row)->where($idfld, $id);
		$result = $this->mongo_db->updateAll($table);
		return $result;
	}


	public function DeletePermanently($idfld, $id, $table)
	{

		$deleteStatus = $this->mongo_db->where($idfld, $id)->deleteAll($table);
		return $deleteStatus;
	}


	public function DeleteAllPermanently($whereConditions, $table)
	{

		$deleteStatus = $this->mongo_db->where($whereConditions)->deleteAll($table);
		return $deleteStatus;
	}


	public function RetriveRecordByNotEqualToIn($field, $fieldVal, $table)
	{

		$returnArray = $this->mongo_db->where([$field => $this->mongo_db->not($this->mongo_db->in([$fieldVal]))])->get($table);
		return $returnArray;
	}


	public function set_cookies($user_id, $password)
	{
		$expire = time() + 60 * 60 * 24 * 1; //$expire = time()+60*5;
		setcookie("user_email", $user_id, $expire);
		//setcookie("user_pwd", $password , $expire);
	}


	public function delete_cookies()
	{
		setcookie("user_email", "", time() - 3600);
		setcookie("user_pwd", "", time() - 3600);
	}


	public function block_account($user_id)
	{

		$login_flag = $this->mongo_db->where('email', $user_id)->get(TBL_USERS);
		$login_count = $login_flag[0]['login_attempt'] + 1;

		if ($login_count >= 3) {
			$updateArr = array(
				'status' 	 => 0,
				'last_login' => date('Y-m-d H:i:s')
			);
			$this->mongo_db->set($updateArr)->where('email', $user_id)->update(TBL_USERS);
		}

		$this->mongo_db->set('login_attempt', $login_count)->where('email', $user_id)->update(TBL_USERS);
		return $login_count;
	}


	public function unlock_account($user_id)
	{
		$updateArry = array(
			'login_attempt' => 0,
			'status' 		=> 1,
			'last_login' 	=> date('Y-m-d H:i:s')
		);
		$this->mongo_db->set($updateArry)->where('email', $user_id)->update(TBL_USERS);
	}


	public function do_password_change()
	{

		$old_password 	= encriptPassword($this->input->post('old_password'));
		$new_password 	= encriptPassword($this->input->post('new_password'));
		$sessUserId 	= new MongoDB\BSON\ObjectId($this->session->userdata('user_db_id'));

		$loginPwd	= $this->RetriveRecordByWhereRow(TBL_USERS, array('_id' => $sessUserId));

		if ($loginPwd[0]['password'] != $old_password) {
			$pwdMsg = 'fail';
		} else {
			$updatePwd = array(
				'password'	 => $new_password,
				'updated_on' => date('Y-m-d H:i:s')
			);
			$this->UpdateAllRecord($updatePwd, TBL_USERS, '_id', $sessUserId);

			$pwdMsg = 'success';
		}
		return $pwdMsg;
	}


	/**
	 * RetriveRecordByWhereOrderby
	 *
	 * Will return all row of provided table as array with provided where clause (optional) order by provided filed.
	 * 
	 * @param string $table
	 * @param array $where_clause
	 * @param string $orderbyfld
	 * @param string $orderby
	 * @return array
	 */

	public function RetriveRecordByWhereOrderby($table, $where_clause, $orderbyfld, $orderby)
	{

		if (!empty($where_clause))
			$this->mongo_db->where($where_clause);
		if (!empty($orderbyfld) && !empty($orderby))
			$this->mongo_db->sort($orderbyfld, $orderby);
		$query = $this->mongo_db->get($table);
		return $query;
	}

	/**
	 * ----------------------------------------------------------------
	 * 	All Above Queries Are Converted into MongoDB's Queries
	 * ----------------------------------------------------------------
	 **/

	/**
	 * RetriveRecordByWhereOrderbyLimit
	 *
	 * Will return all row of provided table as array with provided where clause (optional) order by provided filed and limit.
	 * 
	 * @param string $table
	 * @param array $where_clause
	 * @param string $orderbyfld
	 * @param string $orderby
	 * @param string $limit
	 * @return array
	 */

	public function RetriveRecordByWhereOrderbyLimit($table, $where_clause, $limit, $offset, $orderbyfld, $orderby)
	{
		$this->mongo_db->select('*');
		$this->mongo_db->limit($limit, $offset);
		$this->mongo_db->from($table);
		if (!empty($where_clause))
			$this->mongo_db->where($where_clause);
		$this->mongo_db->order_by($orderbyfld, $orderby);
		$query = $this->mongo_db->get();
		return $query;
	}

	/**
	 * Count
	 *
	 * Count all records of provided table.
	 * 
	 * @param string $table_name
	 * @return int
	 */

	public function Count($table_name)
	{
		$this->mongo_db->select('count(*) as count');
		$this->mongo_db->from($table_name);
		$query = $this->mongo_db->get()->row();
		$tot_rec = $query->count;
		return $tot_rec;
	}

	/**
	 * CountWhere
	 *
	 * Count records of provided table With provided condition.
	 * 
	 * @param string $table_name
	 * @param array $where_clause
	 * @return int
	 */

	public function CountWhere($table_name, $where_clause)
	{
		$this->mongo_db->select('count(*) as count');
		$this->mongo_db->where($where_clause);
		$this->mongo_db->from($table_name);
		$query = $this->mongo_db->get()->row();
		$tot_rec = $query->count;
		return $tot_rec;
	}

	/**
	 * GetRecordSql
	 *
	 * Will return all row of provided table using custom sql query.
	 * 
	 * @param string $sql
	 * @return array
	 */

	public function GetRecordSql($sql)
	{
		$query = $this->mongo_db->query($sql);
		return $query->result();
	}
}
//end of class
