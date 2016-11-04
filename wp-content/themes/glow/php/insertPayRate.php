<?php
    require_once('../../../../wp-config.php');
    //插入pay rate的新纪录，然后更新daily_records里的pay_rate.
	global $wpdb;	
	
	//(1) 插入pay rate的新纪录
	$pay_type="";
	switch ($_POST['pay_type']) {
		case "1":
			$pay_type= "hourly";
			break;
		case "2":
			$pay_type= "daily";
			break;
		case "3":
			$pay_type= "massage";
			break;
		default:
			$pay_type= "/";
	}
	$table="wp_shop_employee_payrate";
	$data_array = array(
		 
			'effective_date' => $_POST['effective_date'],
			'branch_id' => $_POST['branch_name'],
			'depart_id' => $_POST['dep_name'],
			'employee_id' => $_POST['emp_name'],
			'pay_rate' => $_POST['pay_rate'], 
			'pay_type'=> $pay_type,
			'min_hrs'=> $_POST['min_hrs'],
			'ot_rate'=> $_POST['ot_rate']
			 
	);
	//如果存在相同记录。
	$query="select id from ".$table." Where effective_date =" . "'".$_POST['effective_date'] ."'"
	. " AND "."branch_id=" . $_POST['branch_name']." AND "."depart_id=".$_POST['dep_name']
	. " AND "."employee_id=" .  $_POST['emp_name'];
 
	$gr = $wpdb->get_row($query);
	if($gr)
	{//只更新pay rate 和 pay_type 还有min_hrs，ot_rate 即可
		$wpdb->query(
			"
			UPDATE wp_shop_employee_payrate  
			SET pay_rate =" . $_POST['pay_rate'] . 
			" , pay_type =" . $pay_type .
			" , min_hrs =" . $_POST['min_hrs'] .
			" , ot_rate =" . $_POST['ot_rate'] .
			" WHERE id =". $gr->id 
		);
		$query="select * from wp_shop_employee_payrate ORDER BY effective_date ASC ";
		$gr1 = $wpdb->get_results($query);// 
		$len= $wpdb->num_rows; // 获取有多少行。很有用。
		write_operation_log("count(gr1)= ". $len);
		$idx=0;
		foreach ($gr1 as $key => $value)
		{
			$date_min="";
			$origin=print_r($wpdb->get_results($query),true);
			 
			if($idx==0 || $idx==($len-1))
			{
				$date_min=$value->effective_date;//下次用。
				$wpdb->query(
				"
				UPDATE wp_shop_daily_records 
				SET pay_rate =" . $value->pay_rate .
				" , min_hrs =" . $value->min_hrs .
				" , ot_rate =" . $value->ot_rate .
				" WHERE shop_id =". $value->branch_id .
				"	AND team_id=". $value->depart_id  .
				"	AND employee_id=". $value->employee_id  .
				"	AND pay_type =". "'". $value->pay_type ."'".
				"	AND date >= ". "'". $value->effective_date . "'"
				
				);
				 
				$done=" Update: " . " pay_rate " . "to " . $value->pay_rate;
				$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
				write_operation_log($log);
			} 
			else
			{
				$wpdb->query(
				"
				UPDATE wp_shop_daily_records 
				SET pay_rate =" . $value->pay_rate .
				" , min_hrs =" . $value->min_hrs .
				" , ot_rate =" . $value->ot_rate .
				" WHERE shop_id =". $value->branch_id .
				"	AND team_id=". $value->depart_id  .
				"	AND employee_id=". $value->employee_id  .
				"	AND pay_type =". "'". $value->pay_type ."'".
				"	AND date >= ". "'". $date_min . "'".
				" 	AND date <  ". "'". $value->effective_date ."'"
				);
				
				$date_min=$value->effective_date;//下次用。 
				$done=" Update: " . " pay_rate " . "to " . $value->pay_rate;
				$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
				write_operation_log($log);
			}			 
			$idx=$idx+1;
		}
		
		header("Location: {$_SERVER['HTTP_REFERER']}"); //这里要重写返回地址。因该是参数传过来的。
		exit;
	}
	else
	{//如果不存在相同记录，则插入一条。并更新表 daily_records里的pay_rate.
		$wpdb->insert($table,$data_array);
		//write into log
		$origin=print_r($data_array,true);
		$done=" Insert: " . $origin ;
	    $log= $done;
	    write_operation_log($log);
		
		//(2) 更新表 daily_records里的pay_rate	和ot_rate， min_hrs	
		$query="select * from wp_shop_employee_payrate ORDER BY effective_date ASC ";
		$gr1 = $wpdb->get_results($query);// 
		$len= $wpdb->num_rows;
		write_operation_log("count(gr1)= ". $len);
		$idx=0;
		foreach ($gr1 as $key => $value)
		{
			$date_min="";
			$origin=print_r($wpdb->get_results($query),true);
			 
			if($idx==0 || $idx==($len-1))
			{
				$date_min=$value->effective_date;//下次用。
				$wpdb->query(
				"
				UPDATE wp_shop_daily_records 
				SET pay_rate =" . $value->pay_rate .
				" , min_hrs =" . $value->min_hrs .
				" , ot_rate =" . $value->ot_rate .
				" WHERE shop_id =". $value->branch_id .
				"	AND team_id=". $value->depart_id  .
				"	AND employee_id=". $value->employee_id  .
				"	AND pay_type =". "'". $value->pay_type ."'".
				"	AND date >= ". "'". $value->effective_date . "'"
				
				);
				 
				$done=" Update: " . " pay_rate " . "to " . $value->pay_rate;
				$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
				write_operation_log($log);
			} 
			else
			{
				$wpdb->query(
				"
				UPDATE wp_shop_daily_records 
				SET pay_rate =" . $value->pay_rate .
				" , min_hrs =" . $value->min_hrs .
				" , ot_rate =" . $value->ot_rate .
				" WHERE shop_id =". $value->branch_id .
				"	AND team_id=". $value->depart_id  .
				"	AND employee_id=". $value->employee_id  .
				"	AND pay_type =". "'". $value->pay_type ."'".
				"	AND date >= ". "'". $date_min . "'".
				" 	AND date <  ". "'". $value->effective_date ."'"
				);
				
				$date_min=$value->effective_date;//下次用。 
				$done=" Update: " . " pay_rate " . "to " . $value->pay_rate;
				$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
				write_operation_log($log);
			}	
			
			/*
			$wpdb->query(
			"
			UPDATE wp_shop_daily_records 
			SET pay_rate =" . $value->pay_rate .
			" WHERE shop_id =". $value->branch_id .
			"	AND team_id=". $value->depart_id  .
			"	AND employee_id=". $value->employee_id  .
			"	AND pay_type =". "'". $value->pay_type ."'".
			"	AND date >= ". "'".$value->effective_date . "'"//. 
			//" 	AND date < " . "'". $value->effective_date ."'"
			);
			 
			$done=" Update: " . " pay_rate " . "to " . $value->pay_rate;
			$log= $origin . "--->" . $done . PHP_EOL . PHP_EOL ;
			write_operation_log($log);
			*/
			$idx=$idx+1;
		}
		
		
		/******/		 
		header("Location: {$_SERVER['HTTP_REFERER']}"); //这里要重写返回地址。因该是参数传过来的。
		exit;
	}

?> 
