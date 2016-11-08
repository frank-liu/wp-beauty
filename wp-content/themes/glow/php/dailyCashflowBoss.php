<?php
    require_once('../../../../wp-config.php');
   // require('../../../../wp-config.php');
	global $wpdb;
	//$where_clause1=" sh.id=" . $_GET['shop_id'] . " and ";
	//$where_clause2=" cf.shop_id=" . $_GET['shop_id'];
	
    //$query="select s.shop_name, dr.date, dr.employee_id, dr.start_time,dr.end_time, dr.wk_hours,dr.wage,dr.sales,dr.product_id,dr.if_paid from wp_shops s, wp_shop_daily_records dr where s.id=dr.shop_id"; 
	$query="select  
		cf.id,
		cf.date,
		cf.cash,
		cf.card, 
		cf.online, 
		cf.prepaid, 
		cf.refund, 
		cf.total,
		cf.till_start,
		cf.till_end,
		cf.expense,
		cf.wage,
		cf.cash_offset,
		cf.cash_in,
		sh.shop_name   
	from 
		wp_shop_cashflow cf, 
		wp_shops sh  
	where  
		sh.id=cf.shop_id";

 
	$gr1 = $wpdb->get_results($query);// 
	
		
	$row=json_encode($gr1);
	echo ($row);
	exit;
?> 
