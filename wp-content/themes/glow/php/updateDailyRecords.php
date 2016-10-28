<?php
    require_once('../../../../wp-config.php');
   // require('../../../../wp-config.php');
	global $wpdb;
	
	$table="wp_shop_daily_records";
	$data_array=array(
		'if_paid'=>$_POST['paid']
	);
	$where_clause=array(
		'id'=>$_POST['id']
	);
 
	
	//write into log

	$query="select * 
	from 
		wp_shop_daily_records 
	where 
		id=" . $_POST['id']; 
	$gr1 = $wpdb->get_row($query);//query origin entry with id 
	$origin=print_r($gr1,true);
	
	$wpdb->update($table,$data_array,$where_clause);//update db
	//$log="User ID: " . $current_user->ID . ",";	
    
	$done=" Update: " . " if_paid " . "to " . $_POST['paid'];
	$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
	write_operation_log($log);
	
	exit;
?> 
