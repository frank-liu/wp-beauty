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
	
	
	
	//在表 wp_shop_employee_payrate 里找到有效的值，赋值给 pay_rate 和 pay_type
	$query="select pay_rate, pay_type, ot_rate, min_hrs from wp_shop_employee_payrate WHERE effective_date <=". $_POST['date'] 
	. " AND "."branch_id=" . $_POST['shop_name']." AND "."depart_id=".$_POST['dep_name']
	. " AND "."employee_id=" .  $_POST['emp_name'] 
	. " ORDER BY effective_date DESC ";
	$gr = $wpdb->get_row($query);// 
	
	if($gr)
	{//在表 wp_shop_employee_payrate 里找到有效的值
		$pay_rate=$gr->pay_rate;
		$pay_type=$gr->pay_type;
		$ot_rate=$gr->ot_rate;
		$min_hrs=$gr->min_hrs;
	}
	else
	{//找不到则用创建新员工时的值。
		//用创建新员工时的默认值 
		$query="select pay_rate, pay_type, ot_rate, min_hrs from wp_erp_hr_employees WHERE "
		. " branch_id=" . $_POST['shop_name']
		. " AND "."department = ".$_POST['dep_name']
		. " AND "."user_id = " .  $_POST['emp_name'];
		$gr = $wpdb->get_row($query);//
		if($gr)
		{//在表 wp_erp_hr_employees 里找初始默认的值
			$pay_rate=$gr->pay_rate;
			$pay_type=$gr->pay_type;
			$ot_rate=$gr->ot_rate;
			$min_hrs=$gr->min_hrs;
		}
		else{//不存在，取0. 
			$pay_rate=0;
			$pay_type="";
			$ot_rate=0;
			$min_hrs=0;
		}
	}
	
	$data_array = array(
			'shop_id' => $_POST['shop_name'],
			'team_id' => $_POST['dep_name'], //要改 dep_name
			'employee_id' => $_POST['emp_name'],
			'date' => $_POST['date'],
			'start_time' => $_POST['start'],
			'end_time' => $_POST['end'],
			'wk_hours' => $_POST['hours'],
			'ot_hours' => $_POST['ot_hours'],
			
			'pay_rate' => $pay_rate,  
			'pay_type' => $pay_type, 
			'ot_rate' => $ot_rate, 
			'min_hrs' => $min_hrs, 
			
			'sales'=> $prd_sales, //用，分隔每个产品售出的价格。例如：10,20,5			
			
			//'wage'=> $_POST['wages'], 
			'if_paid'=> $_POST['paid'],//ok
			'turnover'=> $_POST['turnover']	//db field  done		
	);
    
	// 同一天不能插入2条相同记录。
	$query="select user_id from wp_shop_daily_records"
	." where shop_id=" . $_POST['emp_name']
	." AND team_id=". $_POST['dep_name']
	." AND employee_id=". $_POST['emp_name']
	." AND date=". $_POST['date'];
	$gr = $wpdb->get_row($query);// 
	if($gr)
	{
		print_r ("1名员工每天在一家店的一个部门只能有1条记录。\n Everyday only 1 entry allowed for each employee at one branch and department.");
	}
	else{
		$wpdb->insert($table,$data_array);
		
		//write into log
		$origin=print_r($data_array,true);
		$done=" Insert: " . $origin ;
	    $log= $done;
	    write_operation_log($log);
		
		header("Location: {$_SERVER['HTTP_REFERER']}"); // return to request page.
	}
	
    exit;
?>




