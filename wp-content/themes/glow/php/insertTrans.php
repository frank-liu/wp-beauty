<?php
/*进阶版
		数据来自表单
        插入数据库表: wp_shop_cashflow
*/
    //header("Content-Type: application/json", true);
    require_once('../../../../wp-config.php');
	global $wpdb;
 
	$table = "wp_shop_cashflow";
	
	//$prd_sales= $_POST['prd_sales_2'] . "," . $_POST['prd_sales_3'] . "," . $_POST['prd_sales_4'];
	
	$data_array = array(
		 
			'date' => $_POST['date'],
			'shop_id' => $_POST['shop_name'],
			'cash' => $_POST['cash'],
			'card' => $_POST['card'],
			'online' => $_POST['online'], 
			'prepaid'=> $_POST['prepaid'],  
			'refund'=> $_POST['refund'], //由manager输入的
			'total'=> $_POST['total'],
			
			'till_start' => $_POST['tillstart'],
			'till_end' => $_POST['tillend'],
			'expense' => $_POST['expense'],
			'wage' => $_POST['wage'],
			'cash_offset' => $_POST['cashoffset'], 
			'cash_in'=> $_POST['cashin'] 
			 
	 	
	);
	
    //if a entry has the date same as the one received, then nothing to do and reminder user that the date has been exsiting.
	$query="select id from  " . $table ." where date =" . $_POST['date']; //$_POST['shop_name'] actually is the shop id .
	$gr = $wpdb->get_row($query);
	if($gr)
	{
		print_r ("existing");
		header("Location: {$_SERVER['HTTP_REFERER']}"); //这里要重写返回地址。因该是参数传过来的。
		exit;
	}
	
	//Must check data validation here
	$query="select id from wp_shops where id=" . $_POST['shop_name']; //$_POST['shop_name'] actually is the shop id .
	//print_r($query);
	$gr = $wpdb->get_row($query);// 
	
	//if matches, then insert data into db
	if($gr->id==$_POST['shop_name']){
		$wpdb->insert($table,$data_array);
		//write into log
		$origin=print_r($data_array,true);
		$done=" Insert: " . $origin ;
	    $log= $done;
	    write_operation_log($log);
		 
		header("Location: {$_SERVER['HTTP_REFERER']}"); //这里要重写返回地址。因该是参数传过来的。
	}
	else{//错误处理
		print_r ("cannot insert into db");
	}
    exit;
?>




