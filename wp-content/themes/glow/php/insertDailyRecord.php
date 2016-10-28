<?php
/*进阶版
		数据来自表单
        插入数据库表: wp_shop_daily_records
*/
    //header("Content-Type: application/json", true);
    require_once('../../../../wp-config.php');
	global $wpdb;
 
	$table = "wp_shop_daily_records";
	
	$prd_sales= $_POST['prd_sales_2'] . "," . $_POST['prd_sales_3'] . "," . $_POST['prd_sales_4'];
	
	$data_array = array(
			'shop_id' => $_POST['shop_name'],
			'team_id' => $_POST['dep_name'], //要改 dep_name
			'employee_id' => $_POST['emp_name'],
			'date' => $_POST['date'],
			'start_time' => $_POST['start'],
			'end_time' => $_POST['end'],
			'wk_hours' => $_POST['hours'],
			
			//'hour_rate' => 7.1, //db field 要换成 turnover. done
			'sales'=> $prd_sales, //用，分隔每个产品售出的价格。例如：10,20,5			
			
			'wage'=> $_POST['wages'], //ok由manager输入的
			'if_paid'=> $_POST['paid'],//ok
			'turnover'=> $_POST['turnover']	//db field  done		
	);
	
    //print_r(array_values($data_array));
	 
	//Must check data validation here
	$query="select user_id from wp_erp_hr_employees where user_id=" . $_POST['emp_name']; //$_POST['emp_name'] actually is the employee id .
	//print_r($query);
	$gr = $wpdb->get_row($query);// 
	
	//if matches, then insert data into db
	if($gr->user_id==$_POST['emp_name']){
		$wpdb->insert($table,$data_array);
		
		//write into log
		$origin=print_r($data_array,true);
		$done=" Insert: " . $origin ;
	    $log= $done;
	    write_operation_log($log);
		
		header("Location: {$_SERVER['HTTP_REFERER']}"); // return to request page.
	}
	else{//错误处理
		print_r ("cannot insert into wp_shop_daily_records");
	}
    exit;
?>




