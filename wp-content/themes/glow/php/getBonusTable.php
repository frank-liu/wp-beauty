<?php
    require_once('../../../../wp-config.php');
   // require('../../../../wp-config.php');
	global $wpdb;
    //$_POST['paid']
   
	//$query="select * from wp_shop_bonus where employee_id= " . $_POST['id'];
	$query="select * from wp_shop_bonus" ;
	 
	$gr1 = $wpdb->get_results($query);// 

	//write into log					 
	//write_operation_log($query);
	
	$row=json_encode($gr1);
	echo ($row);
	
	exit;
?> 
