<?php
/*进阶版
		 
        插入批量数据到表: wp_shop_daily_records
*/
    //header("Content-Type: application/json", true);
    require_once('../../../../wp-config.php');
	global $wpdb;
 
	$table = "wp_shop_daily_records";
	 
	$data = array();//Setup arrays for Actual Values, and Placeholders
    
	$sales="";
	foreach($_POST as $key => $value)
	{
		
		if(strpos($key, 'product_') !== false )
		{
			continue;   
		}
		
		//$k = substr($key, 0, strpos($key, '-'));
		$k=$key;
		//如果是 date  , 则改名为 date 以匹配数据库字段名称。
		if(strpos($k, 'date4batch') !== false )
		{
			$k="date";   
		}
		
		//如果是 shop_name , 则改名为 shop_id 以匹配数据库字段名称。
		if(strpos($k, 'shop_name') !== false )
		{
			$k="shop_id";   
		}
		
		//如果是 dep_name , 则改名为 team_id 以匹配数据库字段名称。
		if(strpos($k, 'dep_name') !== false )
		{
			$k="team_id";   
		}
		
		//如果是 emp_name , 则改名为 employee_id， 以匹配数据库字段名称。
		if(strpos($k, 'emp_name') !== false )
		{
			$k="employee_id";   
		} 
		
		
		
		//如果是 start  , 则改名为 start_time 以匹配数据库字段名称。
		if(strpos($k, 'start') !== false )
		{
			$k="start_time";   
		}
		
		//如果是 end  , 则改名为 end_time 以匹配数据库字段名称。
		if(strpos($k, 'end') !== false )
		{
			$k="end_time";   
		}
		
		//如果是 hours  , 则改名为 wk_hours(实际代表 massage 时间) 以匹配数据库字段名称。
		if(strpos($k, 'servicehours') !== false )
		{
			$k="wk_hours";   
		}
		
		//如果是 turnover  , 则改，匹配数据库字段名称。
		if(strpos($k, 'turnover') !== false )
		{
			$k="turnover";   
		}
		 
		//如果是 ot_hours,  则不改，已经匹配数据库字段名称。
		if(strpos($k, 'ot_hours') !== false )
		{
			$k="ot_hours";   
		}
		//如果是 `paid`, 则改 if_paid ，匹配数据库字段名称
		if(strpos($k, 'paid') !== false )
		{
			$k="if_paid";   
		}
		
		if(strpos($k, 'prd_sales_') !== false)//如果是最后一条记录，则含有prd_sales_4。约定只有4个product，第1个是null，第2个是consumable product，第3个是voucher，第4个是package。
		{
		    $sales = $sales . $_POST[$key] .',';//join prd_sales
			echo "Key: $key; Value: $value<br />\n";
			
			if(strpos($k, 'prd_sales_4') !== false)
			{
				$sales = substr($sales, 0, -1); //remove last comma  substr($string, 0, -1);
				$data['sales'] = $sales;
				$sales="";
				//echo "insert into db <br />\n";
				print_r($data);
				
				//Must check data validation here
				$query="select user_id from wp_erp_hr_employees where user_id=" . $data['employee_id']; //actually is the employee id .
				//print_r($query);
				$gr = $wpdb->get_row($query);// 
				
				
				//if matches, then insert data into db
				if($gr->user_id==$data['employee_id'])
				{
					//找到合适的 pay_type, pay_rate, min_hrs, ot_rate 值，赋值给$data					
					$query="select pay_rate, pay_type, ot_rate, min_hrs from wp_shop_employee_payrate WHERE effective_date <=". $data['date'] 
					. " AND "."branch_id=" . $data['shop_id']." AND "."depart_id=".$data['team_id']
					. " AND "."employee_id=" .  $data['employee_id'] 
					. " ORDER BY effective_date DESC ";
					$gr = $wpdb->get_row($query);// 
					
					if($gr)
					{//在表 wp_shop_employee_payrate 里找到有效的值
						$data['pay_rate']=$gr->pay_rate;
						$data['pay_type']=$gr->pay_type;
						$data['ot_rate']=$gr->ot_rate;
						$data['min_hrs']=$gr->min_hrs;
					}
					else
					{//找不到则用创建新员工时的值。
						//用创建新员工时的默认值 
						$query="select pay_rate, pay_type,ot_rate, min_hrs from wp_erp_hr_employees WHERE "
						. " branch_id=" . $data['shop_id']
						. " AND "."department = ".$data['team_id']
						. " AND "."user_id = " .  $data['employee_id'];
						$gr = $wpdb->get_row($query);//
						if($gr)
						{//在表 wp_erp_hr_employees 里找初始默认的值
							$data['pay_rate']=$gr->pay_rate;
							$data['pay_type']=$gr->pay_type;
							$data['ot_rate']=$gr->ot_rate;
							$data['min_hrs']=$gr->min_hrs;
						}
						else{//不存在，取0. 
							$data['pay_rate']=0;
							$data['pay_type']="";
							$data['ot_rate']=0;
							$data['min_hrs']=0;
						}
					}
					//找到合适的 pay_type, pay_rate, min_hrs, ot_rate 值，赋值给$data
					
					$wpdb->insert($table,$data);
					
					//write into log
					$origin=print_r($data,true);
					$done=" Insert: " . $origin ;
					$log= $done;
					write_operation_log($log);
	 
					header("Location: {$_SERVER['HTTP_REFERER']}"); // return to request page.
					
					//header("Refresh:0;"); // return to request page.
				}
				else{//错误处理
					print_r ( __FILE__ . "cannot insert into wp_shop_daily_records");
				}			
				
				echo "insert into db over <br />\n";
			}
		}
		else{ 
			$data[$k] = $value;
		}		
	}

    exit;
?>




