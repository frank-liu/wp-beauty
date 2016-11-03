

<?php
/*get profile photo*/
    require_once('../../../../wp-config.php');
	global $wpdb;
	//$user_id = $_GET['userid'];
	//print_r($_POST['userid']);
	$user_id =$_GET['userid'];
	$query="SELECT meta_value,user_id FROM wp_usermeta um WHERE um.meta_key='photo_id' AND um.user_id=" . $user_id;
	 
	$mv = $wpdb->get_row($query);// 
	
	//query table : wp_erp_hr_employees
	$query="SELECT branch_id, department, pay_type, pay_rate FROM wp_erp_hr_employees emp WHERE emp.user_id=" . $user_id;
	$pr = $wpdb->get_row($query);//
    $photo="";
	if($mv)
	{
		$photo=wp_get_attachment_image( $mv->meta_value, 'thumbnail');
	}
	switch($pr->pay_type)
	{
		case 'hourly':
		$pay_type=1;
		break;
		case 'daily':
		$pay_type=2;
		break;
		case 'massage':
		$pay_type=3;
		break;
		default: 
		break;
	}
	$arr = array(
	'img_html'=>$photo,
	'user_id'=>$mv->user_id, 
	'payRate'=>$pr->pay_rate,
	'payType'=>$pay_type,
	'branch_id'=>$pr->branch_id,
	'department'=>$pr->department);	
	//print_r(array_values($arr)); // What's the FUCK!!!!!!!!!!!!!!  血一样的教训。print_r 会把输出带到json输出结果里。没事别开着，调试时可以用。
	echo json_encode($arr);
	//print_r(json_encode($arr));
	exit;
?>