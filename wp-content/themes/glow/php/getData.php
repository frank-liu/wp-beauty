
<?php
/*查询数据库表: any*/
    require_once('../../../../wp-config.php');
	global $wpdb;
	$query = $_POST['query'];
	
	$gr1 = $wpdb->get_results($query);// 
	
	$row=json_encode($gr1);
	echo ($row);
	exit;
?>