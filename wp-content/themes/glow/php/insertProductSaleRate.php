<?php
/*进阶版
		数据来自表单
        插入数据库表:  wp_shop_bonus
*/
    //header("Content-Type: application/json", true);
    require_once('../../../../wp-config.php');
	global $wpdb;
 
	$table = "wp_shop_product_rate";
	
	$data_array = array(
		 
			'effective_date' => $_POST['effective_date'],
			'product_id' => $_POST['prd_name'],
			'sales_rate' => $_POST['prd_sale_rate']
			 
	);
 
	
	 
	$wpdb->insert($table,$data_array);
	//write into log
	$origin=print_r($data_array,true);
	$done=" Insert: " . $origin ;
	$log= $done;
	write_operation_log($log);
		 
	header("Location: {$_SERVER['HTTP_REFERER']}"); //这里 返回地址 
	 
    exit;
?>




