
<?php
/*查询数据库表: any*/
    require_once('../../../../wp-config.php');
	global $wpdb;
	$prd_id = $_GET['productId']; 
	$query="SELECT product_cost_band, product_band_rate FROM wp_shop_products prd WHERE prd.product_id=" . $prd_id ;
	//print_r($query);
	$prd = $wpdb->get_row($query);// 
	
	$arr_prd = array(	 
	'cost'=>$prd->product_cost_band,
	'bandRate'=>$prd->product_band_rate	
	);	
	$json_prd = json_encode($arr_prd);
	//print_r($json_prd);
	echo $json_prd;

	exit;
?>