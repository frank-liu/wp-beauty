/******************************************全局变量***********************************************************/
var spreadsheetID = "1nH7lkY7RnFv_l8u0nL9gsrs4_rwODBQiTiuD2FF0GBo";
var myurl = "https://spreadsheets.google.com/feeds/list/" + spreadsheetID + "/1/public/values?alt=json";
var siteUrl=location.origin;
phpUrl = siteUrl + "/wp-beauty/wp-content/themes/glow/php/";
//alert(phpUrl);
/*********************************************************************************************/





/*Tab1 dialog. initialisation */
var dialog = $("#dialog-form").dialog({
		autoOpen : false,
		height : 650,
		width : 450,
		modal : false,

	});
	
/*Tab2 dialog. initialisation */	
var dialog2 = $("#dialog-form-cashflow").dialog({
		autoOpen : false,
		height : 400,
		width : 450,
		modal : false,

	});

$(function () {
	var dialog = $("#dialog-form").dialog({
			autoOpen : false,
			height : 300,
			width : "95%",
			modal : false,
            
			close : function () {
				dialog.find("form")[0].reset();
			}
		});
		
	// dialog in tab2	
	var dialog2 = $("#dialog-form-cashflow").dialog({
			autoOpen : false,
			height : 350,
			width : 700,
			modal : false,             
			close : function () {
				dialog.find("form")[0].reset();
			}
		});
		
	$("#opener").button().on("click", function () {
		order_add();
	});	
});
/*******************************************************************************************************************/



//click to edit the area where you want.
document.addEventListener('DOMContentLoaded', function () {
	//click to edit the area where you want.
	$('#ord_info').click(function () {
		$('#ord_info').attr('contenteditable', 'true');
	});
	

});

/**tab1 dialog validate
*
*/
function dailyRecordsValidation()
{
	//alert("call dailyRecordsValidation, start: "+$("#start").val()+",end:"+$("#end").val());
	//大部分数据校验在前端input处已完成。现在只有一个地方需要校验：
	//当推销金额sales=0，products sold 应该是0.如果sales！=0，products sold必须大于0，即有商品推销出去。
	 
	/*
	if($("#sales").val()==0 && $("#sold").val()!=0)
	{
		alert("因为售价为0.00，所以自动调整为No Product.");
		$("#sold").val(1);
		
		return true;
	}*/
	 
	if($("#start_addRec").val()>=$("#end_addRec").val())
	{
		alert("开始工作时间要早于下班时间");
		$("#start_addRec").css("border", "2px solid red");
		$("#end_addRec").css("border", "2px solid red");
		return false;
	}else{;
		//cal_hours_wage(); //计算工时工资
	}
	
	/*
	if($("#sales").val()>0 && $("#sold").val()<=0)
	{
			$("#sold").css("border", "2px solid red");
			alert("请选择售出的商品。");
			return false;
	}
	else if ($("#sales").val()<0)//售价小于0，不合理退出检查。
	{
		return false;
	}
	else{
		//all validate
		$("#sold").css("border", "1px solid grey");
		return true;
	}*/
	return true;	
	
}


/**tab2 dialog validate
* (1) total == cash + card + online + prepaid - refund
* (2) cash + card + online + prepaid == turnover + product sales
*/
function cashflowValidation()
{
	//alert("cashflowValidation");
	//var flagSameDate=0;
	console.log("records_trans: ");
	console.log(records_trans);
	var result, flag=0;
	for(var i=0;i<records_trans.length;i++)
	{
		//result = $.grep(records_trans[i], function(e){ return e.date === $("#date_trans").val(); });
		if (records_trans[i].date == $("#date_trans").val()) 
		{// multiple items found
			flag=1;
			$("#date_trans").attr("style","border: 2px solid red;")
			alert("The date has been existing, please check the date you entered.");
			break;
		}
	}
	 
	
	if(flag==1)
		return false;// 避免提交数据库， 因为发现了日期重复的记录。
	else{
		return true;
	} 
}

 

//Get current UTC (Universal) Date Time
function ShowUTCDate() {
	var dNow = new Date();
	var utc = new Date(dNow.getTime() + dNow.getTimezoneOffset() * 60000);
	var utcdate = (utc.getMonth() + 1) + '/' + utc.getDate() + '/' + utc.getFullYear() + ' ' + utc.getHours() + ':' + utc.getMinutes() + ':' + utc.getSeconds();
	return utcdate;
}

//get the order ID in a jsGrid row that is highlighted.
function getJsgridOrderId(currentElement) {

	var header = $(".jsgrid-header-row")[0].cells;
	for (var orderIdColInHeader = 0; orderIdColInHeader < header.length; orderIdColInHeader++) {
		if (header[orderIdColInHeader].innerHTML == "OrderID") {
			break;
		}
	}

	var ordid = currentElement.parent().parent().parent().parent().parent()[0].cells[orderIdColInHeader].innerHTML;
	console.log("The colume index of OrderID in the header is: " + orderIdColInHeader);
	console.log("Order ID in the selected row is : " + ordid);
	return ordid;
}

//creat an order ID as : 2位前缀+年月日时分+4位随机流水号
function setOrderId(timestamp) { //2位前缀+年月日时分+4位随机流水号
	var prefix = "CD";
	var date = timestamp;
	date = date.replace(/(\d{2})\/(\d{2})\/(\d{4})/, "$3/$2/$1"); //调整年月日顺序
	date = date.replace(/\/| |:/g, '');

	var randomNumber = Math.floor(Math.random() * 10000);
	var randomNumberStr = "";
	//make sure the serial number is 4 digitals long.
	if(randomNumber>0 && randomNumber<10){
		randomNumberStr="000"+randomNumber;
	}
	if(randomNumber>=10 && randomNumber<100){
		randomNumberStr="00"+randomNumber;
	}
	if(randomNumber>=100 && randomNumber<1000){
		randomNumberStr="0"+randomNumber;
	}
	if(randomNumber>=1000){
		randomNumberStr=randomNumber;
	}

	var ordId = prefix + date + randomNumberStr;
	console.log("An order ID is created: " + ordId);
	return ordId;
}



//split item name and qty from reference
function split_ref() {
	var re = /(.*?[,|\n|\.])/gi;
	var str = '6059x 1,\n\nz3 bk, blackx 3,\n';
	var m1;
	while ((m1 = re.exec(str)) !== null) {
		if (m1.index === re.lastIndex) {
			re.lastIndex++;
		}

		if (m1[0].trim()) {
			alert(m1[0].replace(/,/g, "") + " : " + pick_qty(m1[0]));
			//you should submit the following 2 values to spreadsheets
			//1. item name: m1[0].replace(/,/g, "")    2. itme qty: pick_qty(m1[0])

		}
	}
}

function pick_qty(item_ref) {
	var m;
	var re = /d(\d[x])|([x]\d)|(x[\s]\d)/gi;
	// alert(item_ref);
	while ((m = re.exec(item_ref)) !== null) {

		if (m.index === re.lastIndex) {
			re.lastIndex++;
		}
		// View your result using the m-variable.
		// eg m[0] etc.
		if (m[0].trim()) {
			//alert(m[0]);
			return m[0].trim().replace(/x/g, ""); ;
		}

	}
	if ((m = re.exec(item_ref)) == null) {
		//alert("default:1");
		return 1;
	}
}

/********刷新jsGrid表格并排序 Start*********/
function refresh_jsGrid(){
	$("#jsGrid").jsGrid("refresh");
	$("#jsGrid").jsGrid("sort", {
			field : "date",
			order : "desc"
	});
}
/********刷新jsGrid表格并排序 End*********/


/**********************************insert into jsGrid**************************************pop-up dialog. done */

var submitHandler;

var showDetailsDialog = function (dialogType, category) {
	submitHandler = function (event) {
		category = {};
		saveClient(category, dialogType === "Add");

		//$("#jsGrid").jsGrid("reset");
		// sorting grid by field Timestamp in ascending order
		$("#jsGrid").jsGrid("sort", {
			field : "date",
			order : "desc"
		});
		//alert("refreshed...");
	};

	//order_add(); //assign value to form
	//$( "#dialog-form" ).dialog().dialog("open");

};

var saveClient = function (category, isNew) {

	$.extend(category, {

		//descr_deu: $("#ord_buyername").val(),
		"Timestamp" : "-",
		"Name" : $("#ord_buyername").val(),
		"Address Line 1" : $("#ord_addr1").val(),
		"Address Line 2" : $("#ord_addr2").val(),
		"County" : $("#ord_addr3").val(),
		"Country" : $("#ord_country").val(),
		"Item Reference" : $("#ord_ref").val(),
		"BuyerID" : "",
		"Item ID" : "",
		"Postcode" : $("#ord_zip").val(),
		"Status" : "ready"
	});
	console.log("category:");
	console.log(category);
	$("#jsGrid").jsGrid(isNew ? "insertItem" : "updateItem", category);

	//dialog.dialog("close");
};
/******************************************insert into jsGrid**************************************************** */



//cancel an order info
function order_cancel() {
	var dialog = document.getElementById('window_newOrder');
	/*
	dialog.addEventListener('close', function(e) {
	query_view_sort(0);
	});
	 */
	dialog.close();
	view();
}


//
function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	ev.dataTransfer.setData("Text", ev.target.id);
}

function drop(ev) {
	var data = ev.dataTransfer.getData("Text");
	ev.target.appendChild(document.getElementById(data));
	ev.preventDefault();
}

/******************************************************************************************/
//  

/******************************************************************************************/

/* get your IP		*/
$(function () {
	$.getJSON("https://api.ipify.org?format=jsonp&callback=?",
		function (json) {
		$("#IP").html(json.ip);
	});
});



/*********************************jsGrid******************************************************/

//// insert item to jsGrid
function insertRow() {
 
	insert_phpurl = phpUrl+"insertDailyRecords.php";
	read_phpurl = phpUrl+"dailyRecords.php";
	
	var x;
	$.ajax({
		url : insert_phpurl, // insert entry to database
		dataType : "json"
	})
	.done(function () {	
		$.ajax({
			url : read_phpurl, // insert entry to database
			dataType : "json"
		})
		.done( function (response) {
			var i = response.length;
			x = response[i - 1]; //last one entry
			console.log(i);
			console.log(x);
			console.log(response[i]);
			// insert item

			$("#jsGrid").jsGrid(
				//finishInsert pushes new inserted item into the option data and refreshes the grid

				"insertItem", 
				{
				"date" : x.date,
				"shop_name" : x.shop_name,
				"title" : x.title,
				"display_name" : x.display_name,
				"start_time" : x.start_time,
				"end_time" : x.end_time,
				"wk_hours" : x.wk_hours,
				"sales" : x.sales,
				"product_name" : x.product_name,
				"wage" : x.wage,
				"if_paid":x.if_paid
				})
				.done(function () {
					$("#jsGrid").jsGrid("refresh");
					//this._grid.refresh();

					console.log("insertion completed");
				});
		})
		.fail(function(){
			console.log("insert fail");
		});
	});
}

//Tab1 主体显示表格
$(function () {
	var spreadsheetID = "1nH7lkY7RnFv_l8u0nL9gsrs4_rwODBQiTiuD2FF0GBo";

	//myurl = "https://spreadsheets.google.com/feeds/list/" + spreadsheetID + "/1/public/values?alt=json";
	//var phpurl = $(location).attr('href');	
   // phpurl = phpUrl+"dailyRecords.php";
	var  orderIdClicked="";
    var records = [];
	
		
	
	jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishDelete = function (deletedItem, deletedItemIndex) {
		console.log(deletedItem);
		console.log(deletedItem.Timestamp); //

		//mark this item as deleted in spreadsheet
		// code here:

		var grid = this._grid;
		grid.option("data").splice(deletedItemIndex, 1);
		grid.refresh();
	};

	 	
	
	$("#jsGrid").jsGrid({
		height : "auto",
		width : "100%",

		//filtering: true,
		//sorting : false,
		sorting: true,
		
		editing: false,
		//inserting: false,
		/**/
		autoload : true,
		//autoload : false,
	 
		pagerContainer : "#externalPager",
		paging : true,
		//pageLoading: true,
		pageSize : 10,
		pageIndex : 1,
		pageButtonCount : 5,
		 
		/*rowClick: function(args) { 

			//console.log(args.item.OrderID);
			orderIdClicked=args.item.OrderID;
			return args.item.OrderID;
		},*/
		 
		deleteConfirm : function (item) {
			 
			var msg="The entry ID: \n" +"#"+ item.id + ", " + item.date + "," + item.shop_name + ", " + item.title + ", " + item.display_name +  "\n"
			+ "will be DELETED. \n Are you sure?";
			var deleteFlag=0;
			
			var answer=confirm(msg);
			if (answer==true)
			{
				//php delete a row in table in db				
				$.ajax({
				type: "POST",
				url: phpUrl+"deleteDailyRecord.php",  
				data: {
					id: item.id
				}
				//dataType: "json" //如果没有返回值，就不要写datatype
				})
				.done(function(data) {	
					deleteFlag=1;//表明已删除	
					
					console.log("delete done!");
					return ("The entry has been Deleted.");
				})
				.fail(function(xhr, status, error)
				{
					
					console.log("cannot delete  in db");												 
					console.log(xhr.responseText);
					console.log(status);
					console.log(error);
				});	
			    
				 
			}
			else
			{
				location.reload(false);//刷新页面
				return ("Canceled. Nothing happened.") ;
			}			
		},
		onItemInserted : function (args) {
			//$("#jsGrid").jsGrid("refresh");

			$("#jsGrid").jsGrid("reset");
			alert("Added!");
		},

		controller : {
			loadData : function () {
				var d = $.Deferred();
                var u=$(location).attr('href'); 
				var id=u.substring(u.length-2,u.length-1);// get shop id from url
				
				$.ajax({
					data:{"shop_id":id}, 
					url : phpUrl+"dailyRecords.php",
					dataType : "json"
				})
				.done(function (response) {
					response.sort(function(a,b){
						var aId = a.id ;
						var bId = b.id; 						
						return ((aId < bId) ? -1 : ((aId > bId) ? 1 : 0)); //按 entry ID 顺序排序。这样显示出来是降序的。和我下面算法有关： r = response[--i];
									
					});
					
					console.log(response);
					var i = response.length;
					console.log("object length: "+i);
					$(response).each(function () {
						var r = response[--i]; //one entry//
						console.log("r: "+r);
						var row = {
							"id": r.id,
							"date" : r.date,
							"shop_name" : r.shop_name,
							"title" : r.title,
							"display_name" : r.display_name,
							"start_time" : r.start_time,
							"end_time" : r.end_time,
							"wk_hours" : r.wk_hours,
							"turnover" : "£"+r.turnover,
							"sales" : 
							function (){
								var array = r.sales.split(',');
								var total = 0;
								for (var i = 0; i < array.length; i++) {
									total += parseFloat(array[i]) || 0 ;
								}
								 
								return "£"+ total.toFixed(2);
							},
							//"product_name" : r.prd_sales,
							"ot_hours" : r.ot_hours,
							
							"if_paid": //show icon according to the cell content. ture for 'checked', false for 'x'
							
							function()
							{
								// 根据表格内容，判断显示哪个icon
								//alert(r.id);//get id of the record in db table 
								var icon = "",color = "";
							
								//console.log("id=");
								//var dropDown = $("<div>").attr({"class": "dropdown"}).uniqueId();
								var dropDown = $("<div>").attr({"class": "dropdown","id":"div_paid-"+r.id});
							    
								id=dropDown.attr('id');
								//dropDown.on('click',{param: id},showPaidFlag);//({"onclick":"showPaidFlag("+id+")"});
								//匿名函数传参
								dropDown.on('click',{param: id},function(event){
								
									ele_id="#"+event.data.param+" span";//locate the element <span>
									
									//---get record id from div id
									var str=event.data.param;
									var dialy_rec_id=str.substr(str.indexOf("-")+1);
									
									//update  flag for db
									var update=false;
									
									if($(ele_id).attr('class')=="icon-checkmark")
									{
										if (confirm('Mark it as Not-Paid?')) {
										
											$(ele_id).attr("class", "icon-cross")
											.css({
												'font-size' : "1em",
												'color' : "#f1f1f1" //it's light grey											
											});
											update=true;
											update_val=0;
										}
									}
									else {
										if(confirm("Mark it as Paid?"))
										{
											$(ele_id)
											.attr("class", "icon-checkmark")
											.css({
												'font-size' : "1.4em",
												'color' : "#4CAF50" //it's green										
											});
											update=true;
											update_val=1;
										}
										
									}
									
									//check if need to update db
									if(update)
									{
										//1.php update if_paid value to 1 in db
											$.ajax({
												type: "POST",
												url: phpUrl+"updateDailyRecords.php",  
												data: {
													id: dialy_rec_id,
													paid: update_val
												}
												//dataType: "json" //如果没有返回值，就不要写datatype
											})
											.done(function(data) {
												//2. 
												//$("#jsGrid").jsGrid("refresh");	
												console.log("update done!");
											})
											.fail(function(xhr, status, error)
											{
												console.log("cannot update if_paid value in db");												 
												console.log(xhr.responseText);
												console.log(status);
												console.log(error);
											});
									}
								});
								
								switch (r.if_paid) {
								case '1':
									icon = "icon-checkmark";
									color = "#4CAF50"; //it's green
									break;
								case '0':
									icon = "icon-cross";
									color = "#f1f1f1"; //it's grey
									break;								 
								default:
									break;
								}							
								
								return dropDown.append(
									$("<span>")
									.attr({"class": icon})
									.css({
											'font-size' : "1em",
											'color' : color
										})
								);
							}
						};							
						records.push(row); 
					});
					
					d.resolve(records);					
				})
				.fail(function(){
					console.log("jsGrid load data fail.");
				});
				return d.promise();
			}
		},

		fields : [
			{
				name : "id",
				title : "Entry ID",
				align : "center",
				filtering : false,		
				width : "auto",
				sorter: "number" // sort as number not string.
				
			},
			{
				name : "shop_name", //name对应数据库中字段
				title: "Branch",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
			 
			}, 			
			{
				name : "date",
				title : "Date",
				//type : "date",
				align : "center",
				filtering : false
				 
			}, 
			{
				name : "display_name",
				title: "Employee",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
				 
			}, 
			{
				name : "title",
				title: "Depart",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
				/*headerTemplate : function () {	
					return $("<span>").attr({"class":"icon-th-menu", 'title': 'Department' });
				}*/
			},			
			
			{
				name : "start_time",
				title: "Clock-in",
				editing: true,
				type : "text",
				align : "center",
				autosearch : false,
				width : "auto" 
			}, 
			{
				name : "end_time",
				title: "Clock-out",
				editing: true,
				type : "text",
				align : "center",
				autosearch : false,
				width : "auto" 
			}, 
			{
				name : "wk_hours", //实际是做massage的时间
				title: "Service Hour",
				type : "text",
				editing: false,
				align : "center",
				autosearch : true,
				width : "auto" 
			}, 
			{
				name : "turnover",
				title: "Turnover",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
				/*headerTemplate : function () {
					//return $("<span>").attr("class", "icon-product-hunt");
					return $("<span>").attr({"class":"icon-product-hunt", 'title': 'Turnover' });
				}*/
			},
			{
				name : "sales",
				title: "Sales",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto" 
			},
			 			
			{
				name : "ot_hours",
				title : "OT Hour",
				type : "text",
				align : "center",
				width : "auto",
				filtering : false 
			}, 
			{
				name : "if_paid",
				title : "Paid",
				editing: false, 
				type : "text",
				align : "center",
				width : "auto",
				filtering : false
			},
			{
				type : "control",
				editButton : false,
				deleteButton : true,//为了展示，先暂时关闭
				//deleteButton : false,//为了展示，先暂时关闭
				clearFilterButton : false,
				modeSwitchButton : false,
				width : "auto",

				headerTemplate : function () {
					//return $("<button>").attr("type", "button").attr("class","btn-css plus").text("+")
					return $("<span/>").attr("class", "icon-plus") //Tab1
					.css({
						'font-size' : "1em",
						'color' : "#4CAF50" //it's green
					}).hover(
						function () {
						$(this).css({
							'font-size' : "1.2em",
							'color' : "#00cc00" //it's green
						});
					},
						function () {
						$(this).css({
							'font-size' : "1em",
							'color' : "#4CAF50" //it's green
						});
					}).on("click", function () {
						$("#dialog-form").dialog().dialog("open");
						showDetailsDialog("Add", {});
					});
				}
			}

		]

	});

	// sorting grid by field entry ID in desc order
	$("#jsGrid").jsGrid("sort", {
			field : "id",
			order : "desc"
	});
 
	
});
 
//-------ceshi
$(function() {
  // Handler for .ready() called.
  $(".dropdown > span").on("click", function () {
										console.log($(this));
										//update status icon and color
										if(r.if_paid=='1')
										{
											$(this).attr("class", "icon-cross").css({
												'font-size' : "1em",
												'color' : "#f1f1f1" //it's red
											});
										}
										else{
											paid_flag=1;
											console.log($(this).parent().parent()[0].cells[10]);
											//1.php update if_paid value to 1 in db
											$.ajax({
												url: phpUrl+"get.php",
												data: {paid: paid_flag},
												dataType: "json"
											})
											.done(function() {
												//2.refresh jsgrid
												$("#jsGrid").jsGrid("refresh");												
											})
											.fail(function()
											{
												console.log("cannot update if_paid value in db");
											});
											
										}//end else
											
 
	});
});
//-------ceshi


/*输入做massage的时间小时数*/
function inputServiceHour(id,val)
{
	var r="false";
	if($("#"+id).is('[readonly]'))//在不允许输入的情况下才做下面判断
	{
		var r = confirm("Are you sure that this employee can do the massage job?");
	}

	if (r == true)
	{	
		$("#"+id).attr("readonly",false);//允许用户输入
		alert("Please Enter the value for Massage(service) Hours field: ");
		$("#"+id).attr("style","border: 2px solid #f37373;");
		$("#"+id).focus().focusout(function(){
			$("#"+id).attr("style","border: 1px solid #ccc;");//鼠标离开后，恢复以前的样式。
		});
		$("#"+id).val("0.00");
	}	
}


/*工时计算*/
function cal_wk_hrs() {
	if($("#start").val()<$("#end").val())
	{
         var time1 = $("#start").val().split(':'), time2 = $("#end").val().split(':');
         var hours1 = parseInt(time1[0], 10), 
             hours2 = parseInt(time2[0], 10),
             mins1 = parseInt(time1[1], 10),
             mins2 = parseInt(time2[1], 10);
         var hours = hours2 - hours1, mins = 0;
         if(hours < 0) hours = 24 + hours;
         if(mins2 >= mins1) {
             mins = mins2 - mins1;
         }
         else {
             mins = (mins2 + 60) - mins1;
             hours--;
         }
         mins = mins / 60; // take percentage in 60
         hours += mins;
         hours = hours.toFixed(2);
         $("#hours").val(hours);
         //$("#wages").val((hours* parseFloat($("#hour_rate_val").text())).toFixed(2));
		 
	}
}

//获取商品信息：成本，提成比例
function get_prd_profile()
{
	console.log(" sold val : "+$("#sold").val());
	$.ajax({
			
			url: phpUrl+"getProductDetail.php",
			data: {productId: $("#sold").val()},
			dataType: "json"
	})
	.done(function (data)
	{
		console.log(data);
		console.log(" data.cost : "+data.cost);
		console.log(" data.bandRate : "+data.bandRate);
		//assign value to label Hour Rate
		$("#cost_rate_val").text(data.cost);
		
		$("#band_rate_val ").text(data.bandRate);
	})
	.fail(function (data){
		console.log("load product detail fail.");
		console.log(data);
	});
	
}

//生成指定行数的输入列表
function showRows()
{
	 	
	$("#rows_created").attr({class:''});//显示
	$("#submit").attr({class:'btn btn-success btn-lg btn-block'}); // 显示submit按钮
	
	var entryAmount=$("#rows_amount").val();
	//$("#rowsAmountBuffer").val(entryAmount);//存起来，以便于提交数据库后方便提取数据。
	//console.log("#rowsAmountBuffer: ");
	//console.log($("#rowsAmountBuffer").val());
	id="";
	//复制一份，插入到最后
	for(var entryno=2;entryno<=entryAmount;entryno++)
	{ 
		$("#rows_created fieldset:last")
		.clone()
		//.insertAfter("#rows_created form");
		.insertAfter("#rows_created fieldset:last");
		
	}
	
	
	//重新对name="emp_name"编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="emp_name"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index);
		 			
		}
	);
	//重新对department编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="dep_name"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index);
		 			
		}
	);
	//重新对 start 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="start"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index);
	 			
		}
	);	
	//重新对 end 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="end"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index);
		 			
		}
	);
	//重新对 hours 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="hours"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index);
	 			
		}
	);
	//重新对 ot_hours 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="ot_hours"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index); 
		}
	);
	//重新对 paid 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="paid"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name")+ "-" + index); 
		}
	);
 
	//重新对 profile 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[id="profile"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 			 			
		}
	);
	//重新对 empID id 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[id="empID"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index);  
		}
	);
	//重新对 empID class 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[class="empID"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("class", $(this).attr("class") + "-" + index); 
		}
	);
 
	//重新对 turnover 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="turnover"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 			 			
			$(this).attr("name", $(this).attr("name") + "-" + index); 			 			
		}
	);
	//重新对 prd_sales_2 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="prd_sales_2"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name") + "-" + index); 
		}
	);
	//重新对 prd_sales_3 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="prd_sales_3"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name") + "-" + index); 
		}
	);
	//重新对 prd_sales_4 编号，方便后期提交数据库和显示photo
	$("#rows_created fieldset")
	.find('[name="prd_sales_4"]')
	.andSelf()
	.each(
		function(index) 
		{ 
			$(this).attr("id", $(this).attr("id") + "-" + index); 
			$(this).attr("name", $(this).attr("name") + "-" + index); 
		}
	);
	
	//隐藏创建rows的按钮 
	$("#create_txt_btn").attr('style',"display:none;");
	
}

//show addTransData()
function addTransData(){
	$("#transdata_form").attr({class:''});//显示
	$("#add_transdta_btn").attr({class:'hidden'});//hide
	
	
	
}

//get photo of the employee
// val: <select> input value of the employee 
function get_profile_rec(val) 
{
	 
	$.ajax({
			//type: 'GET', //这行不用写
			url: phpUrl+"getProfile.php",
			//data: {userid: $("#emp_name").val()},
			data: {userid: val},
			dataType: "json"
	})
	.done(function (data)
	{
		//data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
		 
		console.log(data);
		console.log(data.img_html);
		$("#profile_rec").children().remove();		
		$("#profile_rec").append(data.img_html);
		$("#profile_rec img").attr({"class": "img-circle img-responsive", "style":"margin: 12 8;", "width":"42","height":"42"});
		
		
		$("#depart_name_rec").val(data.department);
		$("#empID_rec").text('Empolyee ID: #'+ data.user_id);
		
	})
	.fail(function (data){
		console.log("load pic fail.");		
		console.log(data);
	});
	
}
////get photo of the employee
// val: <select> input value of the employee 
 
function get_profile(val,id) 
{
	var id=id.split("-");
	var id_num=id[id.length-1];
	$.ajax({
			//type: 'GET', //这行不用写
			url: phpUrl+"getProfile.php",
			//data: {userid: $("#emp_name").val()},
			data: {userid: val},
			dataType: "json"
	})
	.done(function (data)
	{
		//data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
		 
		console.log(data);
		console.log(data.img_html);
		$("#profile"+"-"+id_num).children().remove();		
		$("#profile"+"-"+id_num).append(data.img_html);
		$("#profile"+"-"+id_num+" img").attr({"class": "img-circle img-responsive", "style":"margin: 12 8;", "width":"32","height":"32"});
		
		
		$("#depart_name"+"-"+id_num).val(data.department);
		$(".empID"+"-"+id_num).text('Empolyee ID: '+ data.user_id);
		
	})
	.fail(function (data){
		console.log("load pic fail.");		
		console.log(data);
	});
	
}

function show_breakdown()
{
	var phpurl = phpUrl+"getData.php";
	userid=3;
	productid=$("#sold").val();
 
	console.log($("#sold").val());
 
	
	var querystr1 = 
	"select \
		prd.product_band_rate, \
		prd.product_cost_band \
	from \
		wp_shop_products prd \
	where ";
	querystr1+="prd.product_id= ";
	querystr1+= productid;
	
	var querystr2 = 
	"select \
		emp.pay_rate \
	from \
		wp_erp_hr_employees emp \
	where emp.user_id= ";
	querystr2+=userid;
 
	
	$.ajax({
		type: "POST",
		url: phpurl,
		data: {query: querystr1}
	})
	.done( function(data){
	
		data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
		
		$("#band_rate_val").text(data[0].product_band_rate);
		$("#cost_rate_val").text(data[0].product_cost_band);        
		w2=($("#sales").val()-parseFloat(data[0].product_cost_band))* parseFloat(data[0].product_band_rate);
		w2=w2.toFixed(2);
		console.log("w2:"+w2);
		
		$.ajax({
		type: "POST",
		url: phpurl,
		data: {query: querystr2}
		})
		.done( function(data){
			 
			data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
			$("#hour_rate_val").text(data[0].pay_rate);	
			hourly_rate = parseFloat($("#hour_rate_val").text()) ;
			hrs=$("#hours").val();
			w1=(hourly_rate*hrs).toFixed(2);
		 	
			console.log("hourly_rate:"+hourly_rate);
			console.log("hrs:"+hrs);
			console.log("w1:"+w1);
			wg=parseFloat(w1)+parseFloat(w2);
			wg=wg.toFixed(2);
			//$("#wages").val(wg);
			$("#breakdown_val1").text("£"+hourly_rate+" x "+$("#hours").val()+" hrs ="+w1 );
			$("#plus").text("+");
			$("#breakdown_val2").text("( £"+$("#sales").val()+" - £"+ $("#cost_rate_val").text()+" ) x "+$("#band_rate_val").text()+"="+w2 );
			$("#line").text("------------------------------------------------");  
			$("#breakdown_val3").text("= £"+wg );
		})
		.fail(function(){
			console.log("show_breakdown() can't get hour_rate_val from db.");
		});
	})
	.fail(function(){
		console.log("show_breakdown() can't get database.");
	});
	
	//////////////
	
}


//计算基本工资，按小时计算
function cal_hours_wage()
{
	hourly_rate = parseFloat($("#hour_rate_val").text()) ;
	hrs=$("#hours").val();
	w1=(hourly_rate*hrs).toFixed(2);
	//$("#wages").val(w1);
	return w1;
	
}

////计算提成
function  cal_bonus(){
	//var w2=0.0;
	if($("#sales").val()==0 || $("#sales").val()=="")
	{	
        $("#totalWage").val(0);
	}
	w2=($("#sales").val()-parseFloat($("#cost_rate_val").text())) * parseFloat( $("#band_rate_val").text() );
	w2=w2.toFixed(2);
	$("#bonus_val").text(w2);
	console.log("w2:"+w2);
	return w2;
}

// html 调用
function cal_wkhrs_wage()
{
	cal_wk_hrs();//计算工时
	w1=cal_hours_wage(); //计算工资
    w2=cal_bonus(); //计算提成
	w3=parseFloat(w1)+parseFloat(w2);
	$("#totalWage").val(w3.toFixed(2));
	//show_breakdown();//显示工资计算细节
	$("#breakdown_val1").text(w1);
	$("#breakdown_val2").text(w2);
	$("#breakdown_val3").text(w3);

}

//calculate today sales in tab2
function cal_today_sales()
{
	var sum=0;
	sum+=parseFloat($("#card").val());
	sum+=parseFloat($("#cash").val());
	sum+=parseFloat($("#online").val());
	sum-=parseFloat($("#refund").val());
	$("#total").val(sum.toFixed(2));
}

//calculate today sales in tab2
function cal_cashflow()
{
	var sum=0;
	sum+=parseFloat($("#cash").val());
	sum+=parseFloat($("#tillstart").val());
	console.log($("#tillstart").val());
	
	sum+=parseFloat($("#cashoffset").val());
	sum-=parseFloat($("#tillend").val());
	sum-=parseFloat($("#expense").val());
	
	$("#cashin").val(sum.toFixed(2));
}

//
function cal_sale_cashflow()
{
	 
	cal_today_sales();
	cal_cashflow();
	return true;
}

/* print by element id, not working
*
*/
function printDiv(elementId) {
    var a = document.getElementById('printing-css').value;
    var b = document.getElementById(elementId).innerHTML;
    window.frames["print_frame"].document.title = document.title;
    window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
}

 
 var records_trans = [];
$().ready(function () {
	//refresh to show a nice clean table after switch to current tab2.
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  $("#jsGridTransaction").jsGrid("refresh");
	});
	
	//按tab batchinput 显示profile photo href="#menu7"
	$('a[href="#menu7"]').on('shown.bs.tab', function (e) {
	   $("#profile img").attr({"class": "img-circle img-responsive", "style":"margin: 12 8;", "width":"42","height":"42"});
	});

	/***********************************************************Tab2 grid cash flow *****************************************/
	
	$("#jsGridTransaction").jsGrid({
		height : "auto",
		width : "100%",

		//filtering: true,
		sorting : true,
		//editing: true,
		//inserting: false,
		/**/
		autoload : true,
		pagerContainer : "#externalPager2",
		paging : true,
		//pageLoading: true,
		pageSize : 5,
		pageIndex : 1,
		pageButtonCount : 5,
		/**/
		rowClick: function(args) { 

			//console.log(args.item.OrderID);
			orderIdClicked=args.item.OrderID;
			return args.item.OrderID;
		},

		deleteConfirm : function (item) {
			 
			var msg="The entry ID: \n" +"#"+ item.id + ", " + item.date + "," + item.shop_name + ", " + item.title + ", " + item.display_name +  "\n"
			+ "will be DELETED. \n Are you sure?";
			var deleteFlag=0;
			var tb="wp_shop_cashflow";
			var answer=confirm(msg);
			if (answer==true)
			{
				//php delete a row in table in db				
				$.ajax({
					type: "POST",
					url: phpUrl+"deleteData.php",  
					data: {
						id: item.id,
						table: tb
					}
					//dataType: "json" //如果没有返回值，就不要写datatype
				})
				.done(function(data) {	
					deleteFlag=1;//表明已删除	
					
					console.log("delete done!");
					return ("The entry has been Deleted.");
				})
				.fail(function(xhr, status, error)
				{
					
					console.log("cannot delete  in db");												 
					console.log(xhr.responseText);
					console.log(status);
					console.log(error);
				});	
			    
				 
			}
			else
			{
				location.reload(false);//刷新页面
				return ("Canceled. Nothing happened.") ;
			}			
		},
		/*onItemInserting: function(args) {
			// cancel insertion of the item with empty 'name' field
			if(args.item.date === "2016-10-29") {
				args.cancel = true;
				alert("Specify the date of the item!");
			}
		},
		/*onItemInserted : function (args) {
			//$("#jsGrid").jsGrid("refresh");

			$("#jsGrid").jsGrid("reset");
			//alert("refrsh!");
		},*/

		//db below here----------------------------
		controller : {
			loadData : function () {
				var d = $.Deferred();
				 
                var u=$(location).attr('href'); 
				var id=u.substring(u.length-2,u.length-1);// get shop id from url
				
				$.ajax({
					data: {"shop_id":id},
					url : phpUrl+"dailyCashflow.php", // read wp_shop_cashflow table.
					dataType : "json"
				})
				.done(function (response) {
					response.sort(function(a,b){
						var aId = a.id ;
						var bId = b.id; 						
						return ((aId < bId) ? -1 : ((aId > bId) ? 1 : 0)); //按 entry ID 逆序排序。这样显示出来是降序的。和我下面算法有关： r = response[--i];
									
					});
					console.log(response);
					var i = response.length;
					console.log("object length: "+i);
					$(response).each(function () {
						var r = response[--i]; //one entry//
						console.log("r: "+r);
						var row = {
							"id": r.id,
							"date" : r.date,
							"shop": r.shop_name,							
							"cash" : r.cash,
							"card" : r.card,
							"online" : r.online,
							"prepaid" : r.prepaid,
							"refund" : r.refund,
							"total" : r.total,
								
							"tillstart" : r.till_start,
							"tillend" : r.till_end,
							"expense" : r.expense,
							"wage" : r.wage,
							"cashoffset" : r.cash_offset,
							"cashin" : r.cash_in
							};
							
						records_trans.push(row); 
					});
					d.resolve(records_trans);					
				})
				.fail(function(){
					console.log("jsGrid cashflow load data fail.");
				});
				return d.promise();
			}
		},
		//db above ----------------------------

		fields : [
			{
				name : "id", // 对应数组row中的index
				title : "Entry ID",
				type : "text",
				align : "center",
				filtering : false,
			 
				width : "auto"
				
			}, 
			{
				name : "date", // 对应数组row中的index
				title : "Date",
				type : "text",
				align : "center",
				filtering : false,
				width : "auto"
				
			}, 
			{
				name : "total", 
				title : "TOTAL",
				type : "text",
				align : "center",
				css: "red",
				filtering : false,
				sorting : false,
				width : "auto"
				
			},
			{
				name : "card", //name对应数据库中字段
				title: "Card",
				type : "text",
				align : "center",
				css: "blue",
				autosearch : true,
				sorting : false,
				width : "auto"
			},			
			{
				name : "cash",
				title : "Cash",
				type : "text",
				align : "center",
				filtering : false,
				sorting : false,
				css: "blue",
				width : "auto"
			},			 
			{
				name : "online",
				title: "Online",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "blue",
				width : "auto"
			},			
			{
				name : "prepaid",
				title: "Prepaid",
				type : "text",
				align : "center",
				css: "blue",
				autosearch : true,
				sorting : false,
				width : "auto"
			}, 
			{
				name : "refund",
				title: "Refund",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "blue",
				width : "auto"
			}, 
			{
				name : "tillstart",
				title: "Till Start",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "yellow",
				width : "auto"
			},
			{
				name : "tillend",
				title: "Till End",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "yellow",
				width : "auto"
			},
			{
				name : "expense",
				title: "Expense",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "yellow",
				width : "auto"
			},
			{
				name : "wage",
				title: "WAGE",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "yellow",
				width : "auto"
			},
			{
				name : "cashoffset",
				title: "Cash Offset",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : false,
				css: "yellow",
				width : "auto"
			},
			{
				name : "cashin",
				title: "CASH-IN",
				type : "text",
				align : "center",
				css: "red",
				autosearch : true,
				sorting : false,
				width : "auto"
			},
			
			{
				type : "control",
				editButton : false,
				//deleteButton : true,//为了展示，先暂时关闭
				deleteButton : true,//为了展示，先暂时关闭
				clearFilterButton : false,
				modeSwitchButton : false,
				/*
				headerTemplate : function () {
					 
					return $("<span/>").attr("class", "icon-plus") //tab2
					.css({
						'font-size' : "1em",
						'color' : "#4CAF50" //it's green
					}).hover(
						function () {
						$(this).css({
							'font-size' : "1.2em",
							'color' : "#00cc00" //it's green
						});
					},
						function () {
						$(this).css({
							'font-size' : "1em",
							'color' : "#4CAF50" //it's green
						});
					}).on("click", function () {
						$("#dialog-form-cashflow").dialog().dialog("open");
						showDetailsDialog("Add", {});
					});
				}*/
			}
				

		]

	});
	
	
	/****************************************************Tab2 grid end**********************************************************/

	
});
																																			