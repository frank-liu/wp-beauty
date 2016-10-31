<?php
/**
 * Template Name: Boss-Page
 *
 * This is the template that displays all pages by default.
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
	 
	$user = wp_get_current_user(); 
	if ( in_array( 'administrator', (array) $user->roles )==false ) 
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
		echo "You do not have the permission.";
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
  <script src="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/daily-records-boss.js" type="text/javascript"></script>
  <script src="<?php echo get_site_url(); ?>/wp-content/themes/glow/js/jsgrid-1.4.1/jsgrid.min.js" type="text/javascript"></script>
	<!--My css, js link End-->
</head>


    

<div class="container">
	
	<div class="row">
		<!--Logo for boss-->
		<div class="col-sm-4">		 
			<img id="logo" style="width: 326px;height: 46px;margin:1em 0 0 0;" src="<?php echo get_site_url()?>/wp-content/themes/glow/images/logo_herbsHarmony.png"/>
		</div>
	   
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
 
  </br>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Salary Calculator <span class="icon-calculator" style="font-size:1.5em"></span></a></li>
    <li><a data-toggle="tab" href="#menu2">Transactions Check <span class="icon-banknote" style="font-size:1.5em"></span></a></li>
    <li><a data-toggle="tab" href="#menu3">Charts <span class="icon-stats-dots" style="font-size:1.5em"></span></a></li>
	<li><a data-toggle="tab" href="#menu4">Settings <span class="icon-equalizer" style="font-size:1.5em"></span></a></li>
	<li><a data-toggle="tab" href="#menu7">Manual <span class="icon-question-circle" style="font-size:1.5em"></span></a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
		<br/>
		<!--form id="wage_cal_form" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/totalWageBreakdown.php" method="post"-->
		<form id="wage_cal_form" action="">
		<fieldset>
		<div class="row"><!--filter input part start-->			
			<div class="col-sm-2">
				<label for="name-filter">Employee Name</label>
				<select class="form-control" id="name-filter" name="name-filter"  onclick="get_profile(50,50,'#profile-filter','#name-filter')" required>
						<?php $gr = ($wpdb->get_results("SELECT id,display_name FROM wp_users ")); ?>
						<?php foreach ( $gr as $val ) : if($val->id==1) continue;?>
							<option value="<?php echo $val->id?>"><?php echo $val->display_name?></option>
						<?php endforeach; ?>
				</select></br>
			</div>
			 
			<div class="col-sm-1" id="profile-filter" style="padding: 10px 0px 0px 0px;">	<!--员工照片 50x50-->		
			</div>
			
			<div class="col-sm-2">
				<label for="date">From</label>
				<input type="date" class="form-control" id="start-date-filter" name="start-date-filter" value="<?php echo strftime(date("Y-m-d", strtotime("16 days ago"))); ?>" min="2016-10-01" max="<?php echo date('Y-m-d'); ?>" required>
			</div>
			<div class="col-sm-2">
				<label for="date">To</label>
				<input type="date" class="form-control" id="end-date-filter" name="end-date-filter" value="<?php echo date('Y-m-d'); ?>" min="2016-10-01" max="<?php echo date('Y-m-d'); ?>" required>
			</div>
			
			<div class="col-sm-2" style="padding: 26px 0px 0px 0px;">
				<!--提交filter按钮-->		
				<button  class="btn btn-success btn-sm btn-block" onclick="return filterRecords()" >Filter</button>			
			</div>
			
		</div><!--filter input part end-->

		
		<div class="row">
			<div class="col-sm-3"  ><!--Tab1 jsGrid options-->
				<div class="config-panel">			
					<!--label><input id="filtering" type="checkbox" > Filtering</label-->
					<label><input id="editing"  type="checkbox" checked=""> Editing</label>
					<label><input id="paging" type="checkbox" checked=""> Paging</label>
					<label><input id="heading" type="checkbox" checked=""> Heading</label>
				</div >
			</div>
			
			<div  class="col-sm-7"  ><!--加班，offset-->
				<div class="config-panel">
					<label><input id="ot" name="ot-filter" type="number" min="0" step="0.01" value="0.00" checked="" style="width: 70px; height: 24px;padding-left:5px;"> OT Fee</label>
					<label style="width:30px;"> </label>
					<label><input id="offset" name="offset-filter" type="number" step="0.01" value="0.00" checked="" style="width: 70px; height: 24px;padding-left:5px;"> Offset</label>
					<label style="width:40px;"> </label> 
					
					<!--计算工资 按钮-->
				    <input type="submit" class="btn btn-success btn-sm btn-block hidden" value=" Calculate " style="width:100px;display:inline;"/>
				</div >
			</div>
			
			<div class="col-sm-2"><!--打印输出-->
				<div class="config-panel" style="float:right;text-align:right;">
					<!--button ><a class="no-print" href="javascript:printDiv('jsGrid');">Print</a></button-->
					<a class="no-print" href="javascript:printDiv('jsGrid');"><button type="button" class="btn btn-primary btn-sm">Print</button></a>
					<a class="no-print" href="javascript:exportCsv();"><button type="button" class="btn btn-primary btn-sm">.CSV</button></a>
				</div>
			</div>
		</div>
		</fieldset>
		</form><!--end of form "#wage_cal_form" -->
		
		<!--显示工资计算过程的区域-->
		<div class="row" id="wage_breakdown">
			<div id="basic_wage" class="col-sm-3"><!--打印输出基本工资-->
				<div id="basic_wage_pannel" class="panel panel-primary hidden">
					<div class="panel-heading">
						<div class="w3-left"><h3>Basic Wage</h3></div>
						<div class="w3-right"><h3 class="basic_wage_amount"></h3></div>					 
						<p class="calculation" style="clear:both;display:block;"></p>
					</div>
				</div>
			</div>
			<div id="bonus" class="col-sm-3"><!--打印输出奖金-->
				<div id="bonus_pannel" class="panel panel-green hidden">
					<div class="panel-heading">
						<div class="w3-left"><h3>Bonus</h3></div>
						<div class="w3-right"><h3 class="bonus_amount"></h3></div>		
						<p class="calculation" style="clear:both;display:block;"></p>
					</div>	
				</div>	
			</div>	
			<div id="commission" class="col-sm-3"><!--打印输出提成-->
				<div id="commission_pannel" class="panel panel-yellow hidden">
					<div class="panel-heading">
						<div class="w3-left"><h3>Commission</h3></div>
						<div class="w3-right"><h3 class="commission_amount"></h3></div>		
						<p class="calculation" style="clear:both;display:block;"></p>
					</div>
				</div>
			</div>
            <div id="total_wage" class="col-sm-3"><!--打印输出总薪水-->
				<div id="total_wage_pannel" class="panel panel-red hidden">
					<div class="panel-heading">
						<div class="w3-left"><h3>Total Pay</h3></div>
						<div class="w3-right"><h3 class="total_wage_amount"></h3></div>	
						<p class="calculation" style="clear:both;display:block;"></p>
					</div>			
				</div>			
			</div>			
		</div>
		<hr />
		<!--显示给eric看的jsGrid图表1-->
		<div id="jsGrid"></div>
		<div id="externalPager"></div>
	  
    </div>

    <div id="menu2" class="tab-pane fade">
    
	  <br />
	  <!--Tab2 jsGrid options-->
	  <div class="config-panel">
		
		<!--label><input id="filtering" type="checkbox" checked=""> Filtering</label-->
		<label><input id="editing" type="checkbox" checked=""> Editing</label>
		<label><input id="paging" type="checkbox" checked=""> Paging</label>
		<label><input id="heading" type="checkbox" checked=""> Heading</label>
	  </div>
	  <div id="jsGridTransaction"></div>
	  <div id="externalPager2"></div>
      
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Items</h3>
      <!--Div that will hold the pie chart-->
      <div id="chart_div"></div>
	  <div id="geochart_div" style="width: 500px; height: 500px;"></div>
	  
    </div>
	
	
	<div id="menu7" class="tab-pane fade">
      <h3>Documents</h3>
      <iframe id="ifr_query" name="iframe_query" src="https://www.bing.com/" style="border:none" width="100%" height="400"></iframe>
    </div>
	<!--Settings Tab--->
	<div id="menu4" class="tab-pane fade">
      
	  <!-- Set Hourly/Daily rate  --->
	  <h4>Daily/Hourly Rate </h4>
	  <!--这里用jsgrid显示 daily rate -->
	  <hr/>
	  <!-- Set Product Sales Rate --->  
	  <h4>Product Sales Rate</h4>
	  <!--这里用jsgrid显示 bonus rate table -->
	  <div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div id="jsGrid_prd_sale_rate"></div>
			<div id="externalPager_prd_sale_rate"></div>
		</div>
	  </div>
	  <hr/>	
	  
	  <!-- Set Bonus rate 提交数据库 --->      
	  <h4>Bonus Threshold & Rate </h4>
	  <!--这里用jsgrid显示 bonus rate table -->
	  <div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div id="jsGrid_bonus_threshold"></div>
			<div id="externalPager_bonus_threshold"></div>
		</div>
	  </div>
	  <hr/>	
	  
	  <!-- Set Branch's Manager --->
	  <form id="branch_manager_form" action="" method="post">
     
		<div class="row">
			<div class="col-sm-2">
				<h4>Branch Manager</h4>	
			</div>
			<div class="col-sm-1">
				<a id="save_manager_btn" style="background-color:#5cb85c;color:white;padding-left:15px;margin-top: 0.5em; margin-left: -4em;" class="form-control" onclick="saveBranchManager();">Save</a>
			</div>
		</div>
		<fieldset>
		<div class="row">
			<?php $shop = $wpdb->get_results("SELECT * FROM wp_erp_company_locations") ; $idx=0; ?>
			<?php foreach ( $shop as $val ) :?>
			<?php $mgr_id=$val->manager_id;?>
		 
			<div class="col-sm-2">
				<label for="settings">Branch</label>
				<select class="form-control" <?php echo 'id="branch_setting-' . (++$idx) . '"';?>  name="name-filter" readonly   required>
						<option value="<?php echo $val->id;?>" ><?php echo $val->name;?></option>						 
				</select>					 
			</div>
			<div class="col-sm-2">
				<label for="settings">Manager Name</label>
				<select class="form-control" <?php echo 'id="manager_setting-' . ($idx) . '"';?> name="name-filter"   required>
					<?php $mgr = ($wpdb->get_results("SELECT id,display_name FROM wp_users " )); ?>
						
					<?php foreach ( $mgr as $v ) : /*if($val->id==1) continue;*/?>
						<option value="<?php echo $v->id; ?>" <?php if($v->id==$mgr_id) echo 'selected="selected"';?>> <?php echo $v->display_name?></option>	
					<?php endforeach; ?>
				</select>	
			</div>
			<?php endforeach; ?>
		</div>
		</fieldset>
		</form>
		<hr/>
    </div>
	 
    <!--Tab 1 dialog-->  
	<div id="dialog-form" title="Work Log">
		  <form id="order_input_form" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertDailyRecord.php" method="post">
			<fieldset>
					<!--input id="ord_buyername" type="text" value="Employee Name"-->
					<div class="row">
						<div class="col-sm-3">
							<label for="emp_name">Employee</label>
							 <select class="form-control" id="emp_name" name="emp_name"  onclick="get_profile(100,100,'#profile','#emp_name')" required>
								<?php $gr = ($wpdb->get_results("SELECT id,display_name FROM wp_users ")); ?>
								<?php foreach ( $gr as $val ) : if($val->id==1) continue;?>
									<option value="<?php echo $val->id?>"><?php echo $val->display_name?></option>
								<?php endforeach; ?>
							 </select></br>
						</div>
						
						<div class="col-sm-3">
							<label for="date">Date:</label>
							<input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						
						<div class="col-sm-4">
							<label for="shop_name">Shop</label>
							 <select class="form-control" id="shop_name" name="shop_name" required>								
								<?php $gr = ($wpdb->get_results("SELECT id,name FROM wp_erp_company_locations ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->name?></option>
								<?php endforeach; ?>								 
							 </select></br>
						</div>
						<div class="col-sm-2">
							<label for="dep_name">Department</label>
							 <select class="form-control" id="depart_name" name="dep_name" required>
								
								<?php $gr = ($wpdb->get_results("SELECT id,title FROM wp_erp_hr_depts ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->title?></option>
								<?php endforeach; ?>								 
							 </select></br>
						</div>
					</div> 
					<div class="row">
						<div class="col-sm-2" id="profile">	<!--员工照片 no blank line here-->		
						</div>
						<div class="col-sm-2">
							<label for="start">Clock In</label>						
							<input type="time" name="start" min="08:00" max="23:00" class="form-control" id="start" required>
						</div>
						<div class="col-sm-2">
							<label for="end">Clock Out</label>
							<input type="time" name="end" min="08:00" max="23:00" class="form-control" id="end" onmouseout="cal_wk_hrs()" required>
						</div>
						<div class="col-sm-2">
							<label for="hours" >Hours</label> <!--工作时间-->
							<input type="number" name="hours"  readonly="readonly" value='0.00' placeholder='0.00' class="form-control" id="hours" >
						</div>
						<div class="col-sm-2">
							<label for="wages">Wage</label>			
							<input type="number" name="wages" step="0.01" value='0.00' placeholder='0.00' class="form-control" id="wages" >
						</div>
						<div class="col-sm-2">
							<label for="paid">Paid</label>	<!--if be paid-->							 
							<select class="form-control" id="paid" name="paid" required>							 
								<option value="0">NO</option>
								<option value="1">Yes</option>
							 </select>
						</div>
						
					</div> <br/><hr />
					<div class="row">						
						<div class="col-sm-5">
							<label>Product Sold</label>
							<?php $gr = ($wpdb->get_results("SELECT product_id, product_name FROM wp_shop_products ")); ?>
							<?php foreach ( $gr as $val ) : if($val->product_name=="null") continue;?>
							  <input name="product_<?php echo $val->product_id?>" id="product_<?php echo $val->product_id?>" type="text"  value="<?php echo $val->product_name?>" class="form-control" readonly/>
							<?php endforeach; ?>
						 						 
						</div>
						<div class="col-sm-5">
							<label>Product Sales</label>			
							<input id="product_sale_2"  type="number" name="prd_sales_2" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="sales1" >
							<input id="product_sale_3" type="number" name="prd_sales_3" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="sales2" >
							<input id="product_sale_4" type="number" name="prd_sales_4" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="sales3" >
						</div>
						<div class="col-sm-2">
							<label for="turnover" >Turnover</label>			
							<input type="number" name="turnover" min="0" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="turnover" >
						</div>
						
					</div><br /> 					 
				
					<button id="addOrder_btn"  type="submit" tabindex="-1" style="position:absolute; top:-1000px">Submit</button>
					
			</fieldset>	
				<br/><input type="submit" class="btn btn-success btn-lg btn-block" onclick="return dailyRecordsValidation()">
		  </form>
		 
		<br/>
		 
	</div> <!--dialog tab1 end-->
	
	<!--Tab 2 dialog-->  
	<div id="dialog-form-cashflow" title="Daily Transactions">
		  <form id="trans_input_form" onsubmit="cashflow_submit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertTrans.php" method="post">
			<fieldset>					 
				<div class="row">						
					<div class="col-sm-2">
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date2" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
							
							<label for="shop_name">Branch</label>
								<select class="form-control" id="shop_name2" name="shop_name" required>								
									<?php $gr = ($wpdb->get_results("SELECT id,name FROM wp_erp_company_locations ")); ?>
									<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->name?></option>
									<?php endforeach; ?>								 
								</select>
					</div>
						
					<div class="col-sm-5">
							
					</div> 
					<div class="col-sm-5">
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date2" name="date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
					</div>
						
				</div>	<br/>
					
				<div class="row">	
					<div class="col-sm-4">
						<label for="cash">CASH</label>
						<input type="number" name="cash"     value='0.00' placeholder='0.00' class="form-control" id="cash" >
					</div>
						
					<div class="col-sm-4">
						<label for="dep_name">CARD</label>
						<input type="number" name="card"     value='0.00' placeholder='0.00' class="form-control" id="card" >
					</div>
						
					<div class="col-sm-4">
						<label for="online">ONLINE</label>
						<input type="number" name="online"     value='0.00' placeholder='0.00' class="form-control" id="online" >
					</div>
						
						
				</div>	<br/>
				<div class="row">
					<div class="col-sm-4">
						<label for="cash">PREPAID</label>
						<input type="number" name="prepaid"     value='0.00' placeholder='0.00' class="form-control" id="prepaid" >
					</div>
						
					<div class="col-sm-4">
						<label for="refund">REFUND</label>
						<input type="number" name="refund"     value='0.00' placeholder='0.00' class="form-control" id="refund" >
					</div>
					<div class="col-sm-4">
						<label for="total">TOTAL</label>
						<input type="number" name="total"     value='0.00' placeholder='0.00' class="form-control" id="total" >
					</div>					
				</div>
					
					<button id="addCashflow_btn"  type="submit" tabindex="-1" style="position:absolute; top:-1000px">Submit</button>					
			</fieldset>	
				<br/><input type="submit" id="cashflow_submit" class="btn btn-success btn-lg btn-block" onclick="return cashflowValidation()">
		  </form>
		 
		<br/>
		 
	</div> <!-- dialog-form-trans end-->
	
	<!--Tab 4 dialog-form-product-sale -->  
	<div id="dialog-form-product-sale" title="Product Sales Rate">
		  <form id="dialog-form-product-sale" onsubmit="product_sale_submit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertProductSaleRate.php" method="post">
			<fieldset>					 
					<div class="row">	
						<div class="col-sm-4">
							<label for="prd_name">Product Name</label>
							 <select class="form-control" id="prd_name" name="prd_name"   required>
								<?php $gr = ($wpdb->get_results("SELECT product_id,product_name FROM wp_shop_products ")); ?>
								<?php foreach ( $gr as $val ) :?>
									<option value="<?php echo $val->product_id?>"><?php echo $val->product_name?></option>
								<?php endforeach; ?>
							 </select>
						</div>
						
						<div class="col-sm-4">
							<label for="prd_sale_rate">Product Sales Rate</label>
							<input type="number" name="prd_sale_rate"  value='0.00' step="0.01" min="0" max="1" placeholder='0.00' class="form-control" id="prd_sale_rate" required>
						</div> 
						
						<div class="col-sm-4">
							<label for="effective_date">Effective Date</label>
							<input type="date" class="form-control" id="effective_date" name="effective_date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						
					</div>	<br/>
				
			</fieldset>	
				<br/><input type="submit" id="product_sale_submit" class="btn btn-success btn-lg btn-block">
		  </form>
		 
		<br/>
		 
	</div> <!-- dialog-form-product-sale end-->
	
	
	<!--Tab 4 dialog Bonus Threshold -->  
	<div id="dialog-form-bonus-threshold" title="Bonus Threshold Settings">
		  <form id="dialog-form-bonus" onsubmit="bonus_threshold_submit.disabled = true; return true;" action="<?php echo get_site_url(); ?>/wp-content/themes/glow/php/insertBonusThreshold.php" method="post">
			<fieldset>					 
					<div class="row">	
						<div class="col-sm-4">
							<label for="emp_name">Employee</label>
							 <select class="form-control" id="emp_name" name="emp_name"    required>
								<?php $gr = ($wpdb->get_results("SELECT id,display_name FROM wp_users ")); ?>
								<?php foreach ( $gr as $val ) : if($val->id==1) continue;?>
									<option value="<?php echo $val->id?>"><?php echo $val->display_name?></option>
								<?php endforeach; ?>
							 </select>
						</div>
						
						<div class="col-sm-4">
							<label for="dep_name">Department</label>
							 <select class="form-control" id="depart_name" name="dep_name" required>
								
								<?php $gr = ($wpdb->get_results("SELECT id,title FROM wp_erp_hr_depts ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->title?></option>
								<?php endforeach; ?>								 
							 </select>
						</div>
						
						<div class="col-sm-4">
							<label for="shop_name">Branch</label>
							 <select class="form-control" id="shop_name2" name="shop_name" required>								
								<?php $gr = ($wpdb->get_results("SELECT id,name FROM wp_erp_company_locations ")); ?>
								<?php foreach ( $gr as $val ) : ?>
									<option value="<?php echo $val->id?>"><?php echo $val->name?></option>
								<?php endforeach; ?>								 
							 </select>
						</div> 
						
					</div>	<br/>
					
					<div class="row">	
						<div class="col-sm-4">
							<label for="effective_date">Effective Date</label>
							<input type="date" class="form-control" id="effective_date" name="effective_date" value="<?php echo date('Y-m-d'); ?>" min="2016-01-01" max="<?php echo date('Y-m-d'); ?>" required>
						</div>
						
						<div class="col-sm-4">
							<label for="bonus_threshold">Bonus Threshold</label>
							<input type="number" name="bonus_threshold"  value='0.00' min="0" step="0.01" placeholder='0.00' class="form-control" id="bonus_threshold" required>
						</div>
						
						<div class="col-sm-4">
							<label for="bonus_threshold_rate">Threshold Rate</label>
							<input type="number" name="bonus_threshold_rate"  value='0.00' step="0.01" min="0" max="1" placeholder='0.00' class="form-control" id="bonus_threshold_rate" required>
						</div>
					</div>				
			</fieldset>	
				<br/><input type="submit" id="bonus_threshold_submit" class="btn btn-success btn-lg btn-block">
		  </form>
		 
		<br/>
		 
	</div> <!-- dialog-form-bonus-threshold end-->
	
	
	<a id="IP" href="http://geoiplookup.net/ip/"+"javascript:$("IP").innerHTML();" target="_blank"></a>
	<!--Print button-->
	
	<!--textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid blue;padding:0em 0em;text-align:center;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none} .jsgrid-header-row th{width:20em;text-align:center;margin:auto auto;border:1px solid red;}</textarea-->
	<textarea id="printing-css" style="display:none;">.no-print{display:none}.jsgrid-header-row th{width:200px;text-align:center;margin:auto auto;border:1px solid red;} </textarea>
    <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
  </div>
</div>

<?php } ?>
