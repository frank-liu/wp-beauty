<?php
    require_once('../../../../wp-config.php');
   // require('../../../../wp-config.php');
	global $wpdb;
	
	$table="wp_erp_company_locations";
	$data_array=array(
		'manager_id'=>0
	);
	$where_clause=array(
		'id'=>0
	);
  
	foreach($_POST as $key=>$value)
	{
	   $data_array['manager_id']= $value;
		 
		$where_clause['id']= $key;//branch ID
		
		//echo "$_POST[$value]:" . $_POST[$value];
		//write into log

		$query="select * from " . $table . " where id= " . $key; //branch ID 
		$gr1 = $wpdb->get_row($query);//query origin entry with id 
		$origin=print_r($gr1,true);
		
		$wpdb->update($table,$data_array,$where_clause);//update db
		//$log="User ID: " . $current_user->ID . ",";	
		
		$done=" Update: " . "Branch" . $key . " Manager " . " to " . $value . "(Employee ID)";
		$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
		write_operation_log($log);
		 
	 
	}
	 
 
	 
	exit;
?> 
