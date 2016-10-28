<?php
/* 基础Demo版，数据是静态的。事先设定好的。
插入数据库表: wp_shop_daily_records
*/
    require_once('../../../../wp-config.php');
	global $wpdb;
	$table = "wp_shop_daily_records";
	$data_array = array(
			'shop_id' => 1,
			'team_id' => 2,
			'employee_id' => 4,
			'date' => "2016-10-01",
			'start_time' => "09:00:00",
			'end_time' => "10:00:00",
			'wk_hours' => 1,
			'hour_rate' => 6.5,
			'sales'=> 40,
			'product_id'=> 1,
			'wage'=> 40,
			'if_paid'=> 0			
	);
	$wpdb->insert($table,$data_array);
    exit;
?>




