<?php
class Helper
{
	function init_grid($grid_id="")
	{
		$grid = '	<table id="'.strtolower($grid_id).'" style="display:none"></table>';
		return $grid;
	}
	
	function button_val($mode, $button_name) 
	{	
		switch ($mode)
		{
			case 'add':
				return "Create" . $button_name;
				break;
			case 'edit':
				return "Update " . $button_name;
				break;
			case "delete":
				return "Delete " . $button_name;
				break;
			case "import":
				return "Import " . $button_name;
				break;
			case "export":
				return "Export " . $button_name;
				break;
			default: 
				return "&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;";
		}	
	}

	function operation_msg($action="", $result="", $record="")
	{			
		$result_msg = "";
		$is_successful = true;
		if ( $result != "true" ) {
			$is_successful = false;
		}
		
		switch ($action) 
		{
			case 'add':
				$result_msg = $record . " successfully SAVED!";
				if ( $is_successful == false ) {
					
					if ( $result == '' ) {
						$result_msg = "System Function ERROR!";
					} else {
						$result_msg = "Adding " . $record . " failed!";
					}
				}
				break;
			case 'edit':
				$result_msg = $record . " successfully UPDATED!";
				if ( $is_successful == false ) {
					if ( $result == '' ) {
						$result_msg = "You haven't made any changes from the selected record!";
					} else {
						$result_msg = "System Function ERROR!";
					}
				}
				break;
			case 'delete':
				$result_msg = $record . " successfully DELETED!";
				if ( $is_successful == false ) {
					if ( $result == '' ) {
						$result_msg = $record . " delete failed!&nbsp;&nbsp;The record might be already in use or the request cannot be processed.";
					} else {
						$result_msg = "System Function ERROR!";
					}
				}
				break;
			case 'import':
				$result_msg = $record . " successfully IMPORTED!";
				if ( $is_successful == false ) {
					if ( $result == 'mismatch' ) {
						$result_msg = $record . " import failed!&nbsp;&nbsp; Check column count";
					} else {
						$result_msg = "System Function ERROR!";
					}
				}
				break;
			default:
				$result_msg = "";
		}			
		return $result_msg;		
	}
	
	
	function is_editable($mode)
	{		
		switch ($mode)
		{
			case 'view':
				return false;
				break;
			case 'add':
				return true;
				break;
			case 'edit':
				return true;
				break;
			case 'delete':
				return false;
				break;
			default:
				return false;
		}
	}
	
	function pre_print_r($array)
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}


	function unique_id()
	{
		list($usec, $sec) = explode(" ", microtime());
		list($int, $dec) = explode(".", $usec);
		return $sec.$dec;   
	}


	function get_photo_size($file, $postfix="")
	{
		$dot = strrpos($file, '.');
		$ext = substr($file, $dot);		
		$basename = preg_replace('#\.[^.]*$#', '', $file);
		$filename = $basename.$postfix.$ext;

		return $filename;	
	}

	function readable_date($var,$format="M d,Y")
	{
		return date($format, strtotime($var));
	}

	function readable_datetime($var,$format="M d,Y, h:i A")
	{
		return date($format, strtotime($var));
	}
	
	function format_money($number, $fractional=true)
	{
		if ($fractional) {
			$number = sprintf('%.2f', $number);
		}
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			if ($replaced != $number) {
				$number = $replaced;
			} else {
				break;
			}
		}
		return $number;
	} 
	
	function sort_order_validator($tablename,$mode,$id,$column,$extra_query="")
	{
		if($extra_query!=""){
			$extra_query = " AND ".$extra_query;
		}
		
		if($mode=='add' or $mode=='ADD'){
			$maxcontents = 0;
			$sql = '';
			$sql = mysql_query("SELECT * FROM $tablename WHERE $column > 0 $extra_query");
			unset($row);
			while($row = mysql_fetch_array($sql)){
				$contents[] = $row['sort_order'];
			}
			
			if( mysql_num_rows($sql) > 0){
				$maxcontents = max($contents);
			}
			
			$sort_order = $maxcontents + 1;
		}else{
			$sql = mysql_query("SELECT * FROM $tablename WHERE ".$column."= '".$id."' $extra_query");
			$row = mysql_fetch_array($sql);
			$sort_order = $row['sort_order'];
		}
		
		return $sort_order;
	}
	
	
	/*** Check Directory ***/
	function directory_checker($dir=""){
		$diag_result = "";
		if ( !is_dir($dir) ) {
			$diag_result = "The directory <b>($upload_dir)</b> doesn't exist.<br />";
		}
		if ( (!is_writable($dir)) && (is_dir($dir)) ) {
			$diag_result = "The directory <b>($upload_dir)</b> is NOT writable.<br />";
		}
		
		return $diag_result;
	}
	
	/*** Directory Creator ***/
	function directory_maker($dir=""){
		$result = $this->directory_checker($dir);
		
		if ( $result == "The directory <b>($upload_dir)</b> doesn't exist.<br />" ) {
			mkdir($dir, 0755);
		}else{
			echo $result;
			exit();
		}
		
	}
	/**
	 * Delete Image with thumb
	 */
	function delete_image_wt($dir="",$tablename,$ref_id,$id,$column, $extra_query=""){
		$result = false;
		
		if($id>0){
			
			$sql = mysql_query("SELECT * FROM $tablename WHERE $ref_id = '$id' $extra_query");
			if( mysql_num_rows($sql) > 0 ){
				$record = mysql_fetch_array($sql);
				
				if( strlen($record[$column]) > 4 ){
					
					$image_path	= $_SERVER['DOCUMENT_ROOT'].$dir.$record[$column];
					$thumb_path	= $_SERVER['DOCUMENT_ROOT'].$dir.$this->get_photo_size($record[$column], '_s');
					
					if( file_exists($image_path) ){
						@unlink($image_path);
						echo "exist image";
					}
					if( file_exists($thumb_path) ){
						@unlink($thumb_path);
					}
					$result = true;
				}
			}
		}		
		return $result;
	}
	/**
	 * Delete File
	 */
	function delete_file($dir="",$tablename,$ref_id,$id,$column, $extra_query=""){
		$result = false;
		if($id>0){
			$sql = mysql_query("SELECT * FROM $tablename WHERE $ref_id = '$id' $extra_query");
			if( mysql_num_rows($sql) > 0 ){
				$record = mysql_fetch_array($sql);
				if($record[$column] != "" or $record[$column] != NULL){
					$file_path	= $dir.$record[$column];
					if( file_exists($file_path) ){
						@unlink($file_path);
						@unlink($this->get_photo_size($file_path, '_s'));
					}
					$result = true;
				}
			}
		}
		return $result;
	}
	
	/*** ADD TAX CHARGES ***/
	function tax_application($amount){
		$taxes 	= mysql_query("SELECT * FROM ".DB_TABLE_PREFIX."taxmanager WHERE activated='1' ORDER BY sort_order ASC");				
		if ( mysql_num_rows($taxes) > 0  and $amount > 0) :
			$tax_charges = 0;
			while ( $tax = mysql_fetch_object($taxes)){
				$taxmanager_rate = 0;
				$taxmanager_rate = ($tax->is_fixed) > 0 ? ($tax->taxmanager_rate) : ($amount * (($tax->taxmanager_rate)/100));
				$tax_charges  	+= $taxmanager_rate;
			}
			// ADD TAX CHARGES
			$amount = $amount + $tax_charges;
			
		endif;
		return $amount;
	}
	
	/*** RETURN TAX CHARGED ***/
	function total_taxes_applied($amount){
		$taxes 	= mysql_query("SELECT * FROM ".DB_TABLE_PREFIX."taxmanager WHERE activated='1' ORDER BY sort_order ASC");				
		if ( mysql_num_rows($taxes) > 0 and $amount > 0) :
			$tax_charges = 0;
			while ( $tax = mysql_fetch_object($taxes)){
				$taxmanager_rate = 0;
				$taxmanager_rate = ($tax->is_fixed) > 0 ? ($tax->taxmanager_rate) : ($amount * (($tax->taxmanager_rate)/100));
				$tax_charges  	+= $taxmanager_rate;
			}
		endif;
		return $tax_charges;
	}
	
	
	/*** COUNT ALLOCATIONS ***/
	function count_allocation($date,$type,$ref_id){	
		$query = "SELECT * FROM ".DB_TABLE_PREFIX."allocation WHERE type='".$type."' AND calendar_date ='".$date."' AND ref_id ='".$ref_id."'";
		unset($row);
		$allocation = 0;
		$sql = mysql_query($query);
		if( mysql_num_rows($sql) > 0 ){
			while( $row = mysql_fetch_array($sql) ){
				$allocation += ($row['room_allocation']-$row['room_blocked']);
			}
		}
		
		return $allocation;
	}
	
	/*** CHECK DAILY RATE ***/
	function check_dailyrate($arrival_date,$departure_date,$type,$ref_id){	
		
	$query = "SELECT * FROM ".DB_TABLE_PREFIX."allocation WHERE type='".$type."' AND calendar_date >='".$arrival_date."' AND calendar_date <'".$departure_date."' AND ref_id ='".$ref_id."'";
		
		
		unset($row);
		$average_rate = 0;
		$sql = mysql_query($query);
		
		if( mysql_num_rows($sql) > 0 ){
			if ($type==1){
			   	while( $row = mysql_fetch_array($sql) ){	$average_rate += $row['daily_rate'];	}
				$average_rate = $average_rate / (mysql_num_rows($sql));
			}elseif($type==2){
				$sql = '';
				$sql = mysql_query("SELECT * FROM ".DB_TABLE_PREFIX."packagemanager WHERE packagemanager_id='".$ref_id."'");
				$row = mysql_fetch_array($sql);
				$average_rate = $row['default_rate'];
			}else{
			   	$sql = '';
				$sql = mysql_query("SELECT * FROM ".DB_TABLE_PREFIX."promomanager WHERE promomanager_id='".$ref_id."'");
				$row = mysql_fetch_array($sql);
				$average_rate = $row['default_rate'];
			}
		}
		
		return $average_rate;
	}
	
	/*** COUNT ROOMS REMAINING VS RESERVED ***/
	function count_room_remaining($arrival_date,$type,$record_id,$number_of_nights){	
		// CHECK ALLOCATIONS
		$time_stamp	= 0;
		$time_stamp = strtotime($arrival_date);
		for($ctr=0; $ctr<$number_of_nights; $ctr++){
			$time_stamp 	+= 24 * 60 * 60 + $ctr;
			$date 			= date("Y-m-d", $time_stamp);
			$reserved 		= $this->count_reserved($date,$type,$record_id);
			$allocation 	= $this->count_allocation($date,$type,$record_id);
			$room_remaining	+= $allocation-$reserved;
		}
		
		return $room_remaining;
	}
	
	/*** RESERVATION ID GENERATOR ***/
	function transaction_number() {
		$length = 6;
		$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$prefix = '';
		$suffix = '';    
		for ($p = 0; $p < $length; $p++) {	$prefix .= $characters[mt_rand(0, strlen($characters))];	}
		for ($p = 0; $p < $length; $p++) {	$suffix .= $characters[mt_rand(0, strlen($characters))];	}
		return $prefix.date("mdYHi", time())."-". $suffix;
	} 
	
	
	/*** COUNT RESERVATIONS ***/
	function count_reserved($date,$type,$ref_id){	
		$query = "SELECT * FROM ".DB_TABLE_PREFIX."reserved_date AS trd INNER JOIN ".DB_TABLE_PREFIX."reserved_item AS tri ON trd.reserved_id=tri.reserved_id INNER JOIN ".DB_TABLE_PREFIX."reserved AS tr ON tr.reserved_id=tri.reserved_id WHERE tri.type='".$type."' AND trd.reserved_date ='".$date."' AND tri.ref_id ='".$ref_id."'  AND tr.transaction_status='Confirmed'";
		unset($row);
		$reserved = 0;
		$sql = mysql_query($query);
		if( mysql_num_rows($sql) > 0 ){
			while( $row = mysql_fetch_array($sql) ){
				$reserved += $row['qty'];
			}
		}
		
		return $reserved;
	}
	
	/*** VARKEYDUMP ***/
	function varkeydump(){	
		$length = 12;
		$characters = date("mdYgisu", time())."ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$characters .= strtolower("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
		$key = '';
		    
		for ($p = 0; $p < $length; $p++) {	
			$key .= $characters[mt_rand(0, strlen($characters))];	
		}
		return $key;
	}
}
?>