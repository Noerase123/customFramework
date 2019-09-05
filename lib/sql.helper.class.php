<?php
class SQLHelper extends db
{
	function cget_row($table_name="", $where="")
	{		
		if ( $where != "" ) {
			$where = ' WHERE ' . $where ;
		}else{
			$where = '';
		}
		$sql = "SELECT * FROM $table_name " . $where;
		$row = $this->get_row($sql) ;
		return $row;
	}	


	function insert_id($sql)
	{
		mysql_query($sql);
		$id = mysql_insert_id();
		return $id;
	}


	function insert_all($tablename="",$values=array())
	{
		$fields			= "";
		$data_values	= "";
		$ctr			= 0;
		foreach($values as $key=> $value)
		{
			if( $ctr == 0 )
			{
				if($value == "now")
				{
					$fields			.= "`$key`";
					$data_values	.= "NOW()";
				}
				else
				{
					$fields			.= "`$key`";
					$data_values	.= "'$value'";
				}
			}
			else
			{
				if($value == "now")
				{
					$fields			.= ",`$key`";
					$data_values	.= ", NOW()";
				}
				else
				{
					$fields			.= ",`$key`";
					$data_values	.= ",'$value'";	
				}
			}
			$ctr++;
		}
		$sql	= "INSERT INTO `$tablename` ( $fields ) VALUES ($data_values)";
		// echo $sql;
		// exit();
		return $this->insert_id($sql);
	}
	
	
	function update_all($tablename="", $id="", $id_value,$values=array() ,$debug=0)
	{		
		$data_values	= "";
		$ctr			= 0;
		foreach($values as $key=> $value)
		{
			if( $ctr == 0 )
			{
				if($value == "now")
					$data_values	.= "`$key` = NOW() ";
				else
					$data_values	.= "`$key` = '$value' ";
			}
			else
			{
				if($value == "now")
					$data_values	.= ",`$key` = NOW() ";
				else
					$data_values	.= ",`$key` = '$value' ";
			}
			$ctr++;
		}
		$sql	= "UPDATE `$tablename` SET $data_values  WHERE `$id` = $id_value ";
		//echo $sql; exit();
		if ($debug == 1){
			echo $sql; exit();
		}
		$this->query($sql);
		return mysql_affected_rows();		
	}
	
	function activity_log($data = array(),$post_data = array(),$unset_data = array()){
		//foreach($unset_data as $unset){
			//unset($post_data[$unset]);
		//}
		//unset($post_data['image']);
		//unset($post_data['sort_order']);
		//unset($post_data['password']);
		foreach($data as $data_key => $data_value){
			
			foreach($post_data as $post_key => $post_value){
				
				if($data_key == $post_key){
						if($data_value == $post_value){
							
						}
						else{
							$post_activity_data['description'] .= "Has changed to <strong>".$post_value."</strong><br>";
						}
					}
				else{
					
				}
			}
			
		}
		
		return $post_activity_data['description'];
	}

	/*function update_all_permission($tablename="", $id="", $id_value,$values=array())
	{		
		$data_values	= "";
		$ctr			= 0;
		foreach($values as $key => $value)
		{
			if( $ctr == 0 )
			{
				if($value == "now")
					$data_values	.= "`$key` = NOW() ";
				else
					$data_values	.= "`$key` = '$value' ";
			}
			else
			{
				if($value == "now")
					$data_values	.= ",`$key` = NOW() ";
				else
					$data_values	.= ",`$key` = '$value' ";
			}
			$ctr++;
		}
		$sql	= "UPDATE `$tablename` SET $data_values  WHERE `$id` = $id_value ";
		//echo $sql; exit();
		$this->query($sql);
		return mysql_affected_rows();		
	}*/	
	
	function delete($tablename="",$id="",$id_value)
	{
		$sql	= "DELETE FROM $tablename WHERE `$id` = $id_value ";
		$this->query($sql);
		
		return mysql_affected_rows();		
	}
	
	
	function where_like($fields=array(), $value="")
	{
		$where = " WHERE (";
		$ctr = 0;
		foreach($fields as $field) 
		{
			$where .= " $field LIKE '%$value%'";
			$ctr++;
			if ( $ctr < count($fields) ) {
				$where .= " OR";
			}
			
		}
		return $where . ") ";
	}
	
	function sql_count($sql)
	{
		$result = 0;
		$rs     = mysql_query($sql);

		if( mysql_num_rows($rs) > 0 )
		{
			$result = mysql_fetch_array($rs);
			$result = $result[0];
		}

		return $result;
	}
	
	function blockings_allocator($start,$end,$tablename,$id,$type,$default_allocation,$default_rate){
		$current_date = mktime(0, 0, 0, date("m") , date("d"), date("Y"));
		
		for($ctr=$start; $ctr<=($end * 30); $ctr++){
			unset($allocation_post_data);
			$allocation_post_data = array();
			$time_stamp = $current_date;
			$time_stamp += 24 * 60 * 60 * $ctr;
			
			$allocation_post_data['calendar_date'] 		= date("Y-m-d", $time_stamp);			
			$allocation_post_data['type'] 				= $type;
			$allocation_post_data['ref_id'] 			= $id;
			$allocation_post_data['room_allocation'] 	= $default_allocation;
			$allocation_post_data['room_blocked'] 		= '0';
			$allocation_post_data['daily_rate'] 		= $default_rate;
			$allocation_post_data['date_updated'] 		= 'now';
			$allocation_post_data['date_created'] 		= 'now';
			$allocation_id = $this->insert_all($tablename,$allocation_post_data);
			
		}
	}
			function add_email_template($property_code){
			$arr = array("Registration Submision Thank you Message","Account Suspention","New Reservation Notification","Booking Confirmation","Room Allocation Manager Alert Level Notification","Forgotten Password Email","Auto Cancellation Email for Bank Deposit Bookings");
			
			foreach($arr as $value)
			{
			$email_post_data['property_code'] = $property_code;
			$email_post_data['emailtemplatemanager_title'] 	= $value;			
			$email_post_data['date_updated'] 		= 'now';
			$email_post_data['date_created'] 		= 'now';
			$allocation_id = $this->insert_all("tbl_emailtemplatemanager",$email_post_data);
			}
			
			
		}
	
	
	
	
	
	
	
	
	
	
}
	
	
	
	
	


?>