<?php
    require_once('../../../../wp-config.php');
   // require('../../../../wp-config.php');
	global $wpdb;
	
	$table="wp_shop_products";
	//initial
	$data_array=array(
		'product_sale_rate'=>0
	);
	$where_clause=array(
		'product_id'=>0
	);
  
	foreach($_POST as $key=>$value)
	{
		$prd_name=substr($value,0,strpos($value,":"));	
		$rate=substr($value,strpos($value,":")+1,strlen($value)-1);		
		 
		$data_array['product_sale_rate']= $rate;//sales rate
		 
		$where_clause['product_id']= $key; //branch ID
		
	 

		$query="select * from " . $table . " where product_id= " . $key; //branch ID 
		$gr1 = $wpdb->get_row($query);//query origin entry with id 
		$origin=print_r($gr1,true);
		
		$wpdb->update($table,$data_array,$where_clause);//update db
		 
		$done=" Update: " . "Product " . $key . " sales rate " . " to " . $rate ;
		$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
		write_operation_log($log);
		
		//2 update product name
		$data_array['product_name']= $prd_name;//sales rate
		$wpdb->update($table,$data_array,$where_clause);//update db
		 
		$done=" Update: " . "Product " . $key . " name " . " to " . $prd_name ;
		$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
		write_operation_log($log);
	 
	}
	
	exit;
?> 
