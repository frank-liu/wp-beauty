<?php
/*进阶版
		数据来自表单
        插入数据库表:  wp_shop_bonus
*/
    //header("Content-Type: application/json", true);
    require_once('../../../../wp-config.php');
	global $wpdb;
 
	$table = "wp_shop_bonus";
	 
	$data_array = array(
		 
			'effective_date' => $_POST['effective_date'],
			'employee_id' => $_POST['emp_name'],
			'branch_id' => $_POST['shop_name'],
			'depart_id' => $_POST['dep_name'],
			'bonus_threshold' => $_POST['bonus_threshold'], 
			'bonus_threshold_rate'=> $_POST['bonus_threshold_rate']
			 
	 	
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




