<?php
/**
 * Template Name: Branch-Page2
 *
 * For Manager
 *
 *This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*get_header();*/
 
global $wpdb, $wp;
?>

<?php 
	/*/False if a password is not required or the correct password cookie is present; Otherwise true.
	if ( post_password_required() ) {
 
		echo get_the_password_form();
 
	} 
	else { 
	*/
	//$user = wp_get_current_user(); 
	$current_user = wp_get_current_user();/*Get current user*/
	//get shop table
	$current_url = home_url(add_query_arg(array(),$wp->request));/*Get current page URL in WordPress*/
	$gr = ($wpdb->get_row("SELECT * FROM wp_erp_company_locations WHERE ID = " . substr($current_url,-1))); 
	
	if ( ($gr->manager_id != $current_user->ID) && in_array( 'administrator', (array) $current_user->roles )==false ) 
	{
		//The user not the "administrator" role
		 
		 $defaults = array(
			'echo' => true,
			// Default 'redirect' value takes the user back to the request URI.
			'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
			'form_id' => 'loginform',
			'label_username' => __( 'Username or Email' ),
			'label_password' => __( 'Password' ),
			'label_remember' => __( 'Remember Me' ),
			'label_log_in' => __( 'Log In' ),
			'id_username' => 'user_login',
			'id_password' => 'user_pass',
			'id_remember' => 'rememberme',
			'id_submit' => 'wp-submit',
			'remember' => true,
			'value_username' => '',
			// Set 'value_remember' to true to default the "Remember me" checkbox to checked.
			'value_remember' => false,
		);
		echo "You are not the manager or administrator, so you do not have the permission.";
		wp_login_form($defaults);//pop up login form 
		
		exit;
	}
	else{	
?>

<head>
	<meta charset="UTF-8"/>    
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<title><?php echo esc_url( home_url( '/' ) ); ?></title>
	<!--My css, js link Start-->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link type="text/css" rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/jsgrid-1.4.1/jsgrid.min.css" />
  <link type="text/css" rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/jsgrid-1.4.1/jsgrid-theme.min.css" />
  
  <!-- for icon --> 
  <link rel="stylesheet" href="<?php echo get_site_url(); ?>/wp-content/themes/glow/fonts/font/style.css">
  
  <!-- for dropdown Menu-->
  <link href="<?php echo get_site_url(); ?>/wp-content/themes/glow/css/dropdownMenu.css" rel="stylesheet" type="text/css"/> 
  
  <!--button css-->  
  <link href="<?php echo get_site_url(); ?>/wp-content/themes/glow/css/button.css" rel="stylesheet" type="text/css"/> 
  
	 
  
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/daily-records.js" type="text/javascript"></script>
  <script src="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/jsgrid-1.4.1/jsgrid.min.js" type="text/javascript"></script>
	<!--My css, js link End-->
</head>


    

<div class="container">
	<div class="row">
	  <div class="col-sm-4">
		  <h2 style="font-family:Source Sans Pro,Arial,sans-serif;">
			<?php  echo $gr->name;?>
		  </h2>
		  <h4>
			<?php	 $shop=$gr; echo $gr->address_1 . ", " . $gr->zip;//输出branch地址
			?> 
		   </h4>
	   </div>
	   <!--user info name,photo-->
	   <div class="col-sm-4 user_info" style="float:right;text-align:right;">
		  <h2 id="user_info" style="font-family:Source Sans Pro,Arial,sans-serif;text-transform: capitalize">
			<?php
				$photo="SELECT meta_value,user_id FROM wp_usermeta um WHERE um.meta_key='photo_id' AND um.user_id=" . ($current_user->ID);
				$mv = $wpdb->get_row($photo);//
				if($mv)
				{
					echo wp_get_attachment_image( $mv->meta_value, 'thumbnail');
					  
				}
				else 
					echo "";
			?>
			<?php echo  $current_user->display_name ?>
			<a href="<?php echo wp_logout_url( get_permalink() ); ?>"><span class="icon-exit" title="Logout" ></span></a>
		  </h2>
		  <h4 style="text-transform: capitalize;">
			<?php echo "Role: " ;
			   $user_role=$current_user->roles[0];
		  
			   $end=strlen($user_role)-1;
			    if(strpos($user_role,"erp_crm_")!== false)
				{
					$user_role=substr($user_role,8,$end);
				}
				 
				echo $user_role;
			?> 
		   </h4>
	   </div>
	</div>
 
  <!--img src=".\img\travel-mania_logo.png" alt="yourlogo" style="float:right;margin-top:-3em;"-->
  </br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Records <span class="icon-table" style="font-size:1.7em"></span></a></li>
    <li><a data-toggle="tab" href="#menu2">Transaction <span class="icon-th-menu" style="font-size:1.7em"></span></a></li>
    <!--li><a data-toggle="tab" href="#menu3">Sheet <span class="icon-stats-dots" style="font-size:1.5em"></span></a></li-->
	<li><a data-toggle="tab"   href="#menu7">Batch Input <span class="icon-group_add" style="font-size:1.7em"></span></a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
		<h5> </h5>
		<div id="jsGrid"></div>
		<div id="externalPager"></div>
	  
    </div>

    <div id="menu2" class="tab-pane fade">
	  <br />
	  <div id="jsGridTransaction"></div>
	  <div class="row">
		<div id="externalPager2" class="col-sm-6" ></div>
		<div class="col-sm-2" style="float: right;text-align: center;">
			<!--添加trans按钮-->
			<a id="add_transdta_btn" style="background-color:#5cb85c;color:white;height:2em;font-size: 1.5em;padding: 6px 10px;margin-top:0.5em;" class="form-control" href="javascript:addTransData();">Add</a>
		</div>
	  </div>
	  
      <div class="row" id="transdata_form_div"  style="padding-left:1em;padding-right:1em; ">
		<!--tab2 添加记录的表单-->
		<form id="transdata_form" onsubmit="transdataFormSubmit.disabled = true; return true;" class="hidden" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertTrans.php" method="post">
			<hr/>
			<fieldset>				 
					<div class="row">
						<div class="col-sm-2">
						<div class="row">
								<h2>&nbsp;</h2>	
							</div>
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date2" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
						 
							<label for="shop_name">Branch</label>
							<select class="form-control" id="shop_name2" name="shop_name" required>	
								<option value="<?php echo $shop->id?>"><?php echo $shop->name?></option>																 
							</select>
						</div> 
						<div class="col-sm-5">
							<div class="row">
								<h2>TODAY SALES</h2>	
							</div>
							<div class="row">
								<div class="col-sm-5">
									<label for="total">TOTAL</label>
									<input type="number" class="form-control result" id="total" name="total"  min="0" step="0.01" title="This field is calculated automatically." readonly required>
								</div>
								<div class="col-sm-5">
									<label for="card">CARD</label>
									<input type="number" class="form-control" id="card" name="card"    min="0" step="0.01"    required>
									<label for="cash">CASH</label>
									<input type="number" class="form-control" id="cash" name="cash"   min="0" step="0.01"    required>
									<label for="online">ONLINE</label>
									<input type="number" class="form-control" id="online" name="online"   min="0" step="0.01"    required>
									<label for="prepaid">PREPAID</label>
									<input type="number" class="form-control" id="prepaid" name="prepaid"   min="0" step="0.01"    required>
									<label for="refund">REFUND</label>
									<input type="number" class="form-control" id="refund" name="refund"   min="0" step="0.01"    required>
								</div>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="row">
								<h2>CASHFLOW</h2>	
							</div>
							<div class="row">								
								<div class="col-sm-5">
									<label for="tillstart">TILL START</label>
									<input type="number" class="form-control" id="tillstart" name="tillstart"   min="0" step="0.01"    required>
									
									<label for="tillend">TILL END</label>
									<input type="number" class="form-control" id="tillend" name="tillend"   min="0" step="0.01"    required>
									
									<label for="expense">EXPENSE</label>
									<input type="number" class="form-control" id="expense" name="expense"   min="0" step="0.01"    required>
									<label for="wage">WAGE</label>
									<input type="number" class="form-control" id="wage" name="wage"   min="0" step="0.01"    required>
									<label for="cashoffset">CASH OFFSET</label>
									<input type="number" class="form-control" id="cashoffset" name="cashoffset"   min="0" step="0.01"    required>
								</div>
								<div class="col-sm-5">
									<label for="cashin">CASH-IN</label>
									<input type="number" class="form-control result" id="cashin" name="cashin"  min="0" step="0.01" title="This field is calculated automatically." readonly required>
								</div>
							</div>
						</div>
					</div>	<br/>
					
					 
					
					<!--button id="addCashflow_btn"   type="submit" tabindex="-1" style="position:absolute; top:-1000px">Submit</button-->					
			</fieldset>	
				<br/><input type="submit" name="transdataFormSubmit" onmouseover="return cal_sale_cashflow()" class="btn btn-success btn-lg btn-block" >
		  </form>
	  </div>
		
	</div>
  
	
	<!--批量输入员工记录tab-->
	<div id="menu7" class="tab-pane fade">
	 <!--批量输入员工记录 新风格在这里--->
	  <div id="rows_created" >
		<form id="batch_input_form" onsubmit="batchInputSubmit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertBatchDailyRecord.php" method="post"><!--批量提交-->
			<div class="row">
			<div class="col-sm-2">
				<label for="shop_name">Branch</label>
				<select class="form-control" id="shop_name" name="shop_name" required>	
					<option value="<?php echo $shop->id?>"><?php echo $shop->name?></option>																 
				</select>							
			</div>
			<div class="col-sm-2">
				<label for="date">Date</label>
				<input type="date" class="form-control" style="font-size:12px;" id="date4batch" name="date4batch" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
			</div>
			<div class="col-sm-2">
				<label for="rows_amount">How many rows? </label><!--记录数-->
				<input type="number" class="form-control" style="font-size:12px;padding-left:4px;" step="1" value="1" min="1" max="15" id="rows_amount"  placeholder="0" required>
			</div>
			<div class="col-sm-1"><!--create按钮-->
				<label > <br/></label>			 
				<a id="create_txt_btn" style="background-color:#5cb85c;color:white;padding-left:10px;" class="form-control" href="javascript:showRows();">Create</a>
			</div>
			</div><hr/>
			
			<fieldset id="form_fieldset" class="form_fieldset hidden">
			<div class="row">	
				<div class="col-sm-2">
					<label for="emp_name">Employee</label><!--employee name -->
					<select class="form-control" id="emp_name" name="emp_name" onclick="get_profile(this.value,this.id)" required>
						<?php $gr = ($wpdb->get_results("SELECT id,display_name FROM wp_users ")); ?>
						<?php foreach ( $gr as $val ) : if($val->id==1) continue;?>
							<option value="<?php echo $val->id?>"><?php echo $val->display_name?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="col-sm-2"><!--Department-->
							<label for="dep_name">Department</label>
							 <select class="form-control" id="depart_name" name="dep_name" required>								
								<?php $gr = ($wpdb->get_results("SELECT id,title FROM wp_erp_hr_depts ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->title?></option>
								<?php endforeach; ?>								 
							 </select>
				</div>
				
				<div class="col-sm-2"><!--Clock In-->
							<label for="start">Clock In</label>						
							<input type="time" name="start" min="08:00" max="23:00" class="form-control" id="start" required>
				</div>
				<div class="col-sm-2"><!--ClockOut-->
							<label for="end">ClockOut</label>
							<input type="time" name="end" min="08:00" max="23:00" class="form-control" id="end" onmouseout="cal_wk_hrs()" required>
				</div>
				
				<div class="col-sm-2"><!--Service Hours-->
					<label for="servicehours" >Service Hours</label> <!--service 时间-->
					<input type="number" title="Service Hours" name="servicehours" min="0.00" max="12.00" step="0.01" class="form-control" id="servicehours" readonly='readonly' onclick="inputServiceHour(this.id,this.value)" required>
				</div>
				<div class="col-sm-1"><!--OT Hours-->
					<label for="ot_hours">OT Hours</label>			
					<input type="number" name="ot_hours" min="0.00" step="0.01" value='0.00' class="form-control" id="ot_hours" required>
				</div>
				<div class="col-sm-1"><!--Paid-->
						<label for="paid">Paid</label>	<!--if be paid-->							 
						<select class="form-control" id="paid" name="paid" required>							 
								<option value="0">No</option>
								<option value="1">Yes</option>
						</select>
				</div>
				
			</div><!--end of #row1-->
			<div class="row">
				<div class="col-sm-1" id="profile">	<!--员工照片 no blank line here-->		
				</div>				
				<div class="col-sm-1" id="empID">	<!--员工ID-->
					<div class="empID">					
					</div>					
				</div>	
				<div class="col-sm-1"> <!--Turnover-->
						<label for="turnover" >Turnover</label>			
						<input type="number" name="turnover" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="turnover" required>
				</div>
					 
				<?php $gr = ($wpdb->get_results("SELECT product_id, product_name FROM wp_shop_products "));?>						
				<?php foreach ( $gr as $val ) : if($val->product_name=="null") continue;?>
						<?php echo '<div class="col-sm-2">' ?>
						<?php echo '<label>Product Sold</label>';?>
							<input name="product_<?php echo $val->product_id?>" style="padding-left:4px;" id="product_<?php echo $val->product_id?>" type="text"  value="<?php echo $val->product_name?>" class="form-control" readonly/>
						
						<?php echo '</div>'//end of col-sm-2 ?>
						
						<?php echo '<div class="col-sm-1">' ?>
						<?php echo '<label>Sales</label>'?>
						<input id="product_sale_<?php echo $val->product_id?>" style="padding-left:4px;" type="number" name="prd_sales_<?php echo $val->product_id?>" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="sales<?php echo $val->product_id?>" >
						<?php echo '</div>'//end of col-sm-1 ?>
				<?php endforeach; ?>
			</div><!--end of #row2-->
			<hr/>
			</fieldset>	
			<input type="submit" id="submit" name="batchInputSubmit" class="btn btn-success btn-lg btn-block hidden" value="Submit" onclick="return insertBatchDailyRecord()"> 
		</form>
				  
	  </div><!--新风格在这里结束--->
    </div><hr/>
	 
    <!--Tab 1 dialog-->  
	<div id="dialog-form" title="Records">
		  <form id="order_input_form" onsubmit="dialyrecord_submit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertDailyRecord.php" method="post">
			<fieldset>
					<div class="row">
						<div class="col-sm-3">
							<div class="row">
								<div class="col-sm-12">
									<label for="emp_name">Employee</label>
									<select class="form-control" id="emp_name" name="emp_name"  onclick="get_profile_rec(this.value)" required>
										<?php $gr = ($wpdb->get_results("SELECT id,display_name FROM wp_users ")); ?>
										<?php foreach ( $gr as $val ) : if($val->id==1) continue;?>
											<option value="<?php echo $val->id?>"><?php echo $val->display_name?></option>
										<?php endforeach; ?>
									</select>
								</div>
								 
							</div>
							<div class="row">
								<div class="col-sm-4" id="profile_rec"><!--员工照片  -->	
								</div>
								
								<div class="col-sm-8">
									<!--员工ID-->
									<div>
									<label id="empID_rec" class="margin-top: 0.5em;">Empolyee ID:					
									</label>					
									</div> 
									<label for="shop_name">Branch</label>
									<select class="form-control" id="shop_name" name="shop_name" required>								
										
										<option value="<?php echo $shop->id?>"><?php echo $shop->name?></option>
																		 
									</select>
									
									<label for="dep_name">Department</label>
									<select class="form-control" id="depart_name_rec" name="dep_name" required>
										
										<?php $gr = ($wpdb->get_results("SELECT id,title FROM wp_erp_hr_depts ")); ?>
										<?php foreach ( $gr as $val ) : ?>
											<option value="<?php echo $val->id?>"><?php echo $val->title?></option>
										<?php endforeach; ?>								 
									</select>
								</div>
								 
							</div>
						</div>
						
						<div class="col-sm-2">
							<div class="row">
								<div class="col-sm-12">
									<label for="date">Date</label>
									<input type="date" class="form-control" style="font-size:12px;" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="margin-top: 1.8em;">
									<label for="start">Clock-In</label>						
									<input type="time" name="start" min="08:00" max="23:00" class="form-control" id="start_addRec" required>
									<label for="end">Clock-Out</label>
									<input type="time" name="end" min="08:00" max="23:00" class="form-control" id="end_addRec"   required>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="row">
								<div class="col-sm-4">
									<label for="turnover">Turnover</label>			
									
								</div>
								<div class="col-sm-4">
									<label for="hours" >Service Hours</label> <!--massage时间-->
								</div>
								
								<div class="col-sm-4">
									<label for="ot_hours">OT Hours</label>			
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									 	
									<input type="number" name="turnover" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="turnover"  >
								
								</div>
								<div class="col-sm-4">
									 
									<input type="number" name="hours"  placeholder='0.00' step="0.01" class="form-control" id="hours_tab1"  >
								</div>
								
								<div class="col-sm-4">
									 			
									<input type="number" name="ot_hours" placeholder='0.00' step="0.01"  class="form-control" id="ot_hours"  >
								
								</div>
							</div>
						</div>
						
						
						<!--product_name--->
						
						<div class="col-sm-3">
							<div class="row">
								<div class="col-sm-8">
									<label>Product Sold</label>   
								</div>
								<div class="col-sm-4">
									<label>Product Sales</label>
								</div>
							</div>
							<!-- 循环3次。-->
							<?php $gr = ($wpdb->get_results("SELECT product_id, product_name FROM wp_shop_products ")); ?>
							<?php foreach ( $gr as $val ) : if($val->product_name=="null") continue;?>
								<div class="row" style="margin-top: 0.2em;">
									<div class="col-sm-8">
									
									  <input name="product_<?php echo $val->product_id;?>" id="product_<?php echo $val->product_id;?>" type="text"  value="<?php echo $val->product_name;?>" class="form-control" readonly/>
																						 
									</div>
									
									<div class="col-sm-4">
													
										<input <?php echo 'id="product_sale_'. $val->product_id.'"';?>  type="number" <?php echo 'name="prd_sales_'. $val->product_id.'"';?> min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="sales1" >
										
									</div> 
								</div> 
							<?php endforeach; ?>
						</div>
						
						<div class="col-sm-1">
							<label for="paid">Paid</label>	<!--if be paid-->							 
							<select class="form-control" id="paid" name="paid" required>							 
								<option value="0">NO</option>
								<option value="1">Yes</option>
							 </select>
						</div>
					</div>	
					
										 
				
					<button id="addOrder_btn"  type="submit" tabindex="-1" style="position:absolute; top:-1000px">Submit</button>
					
			</fieldset>	
			    <!--单一提交按钮-->
				<br/><input id="dialyrecord_submit" type="submit" class="btn btn-success btn-lg btn-block" onclick="return dailyRecordsValidation()">
			
		  </form>
		 
		<br/>
		 
	</div> <!--dialog tab1 end-->
	<!--Tab 2 dialog 显示cashflow-->  
	<div id="dialog-form-cashflow" title="Daily Transactions">
		  <form id="trans_input_form" onsubmit="trans_input_form_submit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertTrans.php" method="post">
			<fieldset>
					 
					<div class="row">	
						<div class="col-sm-6">
							<label for="shop_name">Shop</label>
							<select class="form-control" id="shop_name2" name="shop_name" required>								
								<?php $gr = ($wpdb->get_results("SELECT id,name FROM wp_erp_company_locations ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->name?></option>
								<?php endforeach; ?>								 
							</select>
						</div> 
						
						<div class="col-sm-6">
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date2" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						
					</div>	<br/>
					
					<div class="row">	
						<div class="col-sm-4">
							<label for="cash">Cash:</label>
							<input type="number" name="cash"     value='0.00' placeholder='0.00' class="form-control" id="cash" >
						</div>
						
						<div class="col-sm-4">
							<label for="dep_name">Card:</label>
							<input type="number" name="card"     value='0.00' placeholder='0.00' class="form-control" id="card" >
						</div>
						
						<div class="col-sm-4">
							<label for="online">Online:</label>
							<input type="number" name="online"     value='0.00' placeholder='0.00' class="form-control" id="online" >
						</div>
						
						
					</div>	<br/>
					<div class="row">
						<div class="col-sm-4">
							<label for="cash">Prepaid:</label>
							<input type="number" name="prepaid"     value='0.00' placeholder='0.00' class="form-control" id="prepaid" >
						</div>
						
						<div class="col-sm-4">
							<label for="refund">Refund:</label>
							<input type="number" name="refund"     value='0.00' placeholder='0.00' class="form-control" id="refund" >
						</div>
						<div class="col-sm-4">
							<label for="total">Total:</label>
							<input type="number" name="total"     value='0.00' placeholder='0.00' class="form-control" id="total" >
						</div>
					
					</div>
					
					<button id="addCashflow_btn"  type="submit" tabindex="-1" style="position:absolute; top:-1000px">Submit</button>					
			</fieldset>	
				<br/><input type="submit" name="trans_input_form_submit" class="btn btn-success btn-lg btn-block" onclick="return cashflowValidation()">
		  </form>
		 
		<br/>
		 
	</div> <!-- dialog-form-trans end-->
		
	  <!--button id="opener">Add a new</button-->
	<a id="IP" href="http://geoiplookup.net/ip/"+"javascript:$("IP").innerHTML();" target="_blank"></a>
	<!--Print button-->
	<a style="float:right;text-align:right;" class="no-print" href="javascript:printDiv('jsGrid');">Print</a> 
	<textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em;text-align:left;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}</textarea>
    <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
  </div>
</div>

<?php } ?>
