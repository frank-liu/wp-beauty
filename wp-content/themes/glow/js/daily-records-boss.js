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
	
/*Tab4 dialog. initialisation */	
var dialog4 = $("#dialog-form-bonus-threshold").dialog({
		autoOpen : false,
		height : 400,
		width : 450,
		modal : false,

	});
/*Tab4 dialog. initialisation */	
var dialog5 = $("#dialog-form-product-sale").dialog({
		autoOpen : false,
		height : 400,
		width : 450,
		modal : false,

	});
	/*Tab4 dialog. pay rate, initialisation */	
var dialog6 = $("#dialog-form-pay-rate").dialog({
		autoOpen : false,
		height : 400,
		width : "50%",
		modal : false,

	});

$(function () {
	var dialog = $("#dialog-form").dialog({
			autoOpen : false,
			height : 550,
			width : 900,
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
		
	var dialog6 = $("#dialog-form-pay-rate").dialog({
			autoOpen : false,
			height : 300,
			width : "60%",
			modal : false,             
			close : function () {
				dialog.find("form")[0].reset();
			}
		});
	// dialog in tab4	
	var dialog5 = $("#dialog-form-product-sale").dialog({
			autoOpen : false,
			height : 300,
			width : 700,
			modal : false,             
			close : function () {
				dialog.find("form")[0].reset();
			}
		});
	// dialog in tab4	
	var dialog4 = $("#dialog-form-bonus-threshold").dialog({
			autoOpen : false,
			height : 300,
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

/**/
function insertBatchDailyRecord()
{
	//location.reload(true);//刷新页面
	
	$("#batch_input_form #submit").attr("disabled","true");
	$("#batch_input_form #submit").attr("class","hidden");
	
	return true;
}

// val: <select> input value of the employee 
function get_profile_rec(val) 
{
	 
	$.ajax({
			//type: 'GET', //这行不用写
			url: phpUrl+"getProfile.php",	
			data: {userid: val},
			dataType: "json"
	})
	.done(function (data)
	{
		//data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
		 
		console.log(data);
		console.log(data.img_html);
		//$("#profile_rec").children().remove();		
		//$("#profile_rec").append(data.img_html);
		//$("#profile_rec img").attr({"class": "img-circle img-responsive", "style":"margin: 12 8;", "width":"42","height":"42"});
		
		
		$("#branch_name").val(data.branch_id);
		$("#depart_name_payrate").val(data.department);
		$("#empID_rec").text(' (ID: #'+ data.user_id+')');
		$("#pay_type").val(data.payType);
		$("#pay_rate").val(data.payRate);
		$("#ot_rate").val(data.ot_rate);
		$("#min_hrs").val(data.min_hrs);
		
	})
	.fail(function (data){
		console.log("load pic fail.");		
		console.log(data);
	});
	
}

/**tab1 dialog validate
*
*/
function dailyRecordsValidation()
{
	//alert("call dailyRecordsValidation, start: "+$("#start").val()+",end:"+$("#end").val());
	//大部分数据校验在前端input处已完成。现在只有一个地方需要校验：
	//当推销金额sales=0，products sold 应该是0.如果sales！=0，products sold必须大于0，即有商品推销出去。
	 
	
	if($("#sales").val()==0 && $("#sold").val()!=0)
	{
		alert("因为售价为0.00，所以自动调整为No Product.");
		$("#sold").val(1);
		
		return true;
	}
	if($("#start").val()=="" || $("#end").val()=="") //如果没有输入上班时间
	{
		alert("请输入工作时间");
		$("#start").css("border", "2px solid red");
		$("#end").css("border", "2px solid red");
		return false;
	}
	if($("#start").val()>=$("#end").val())
	{
		alert("开始工作时间要早于下班时间");
		$("#start").css("border", "2px solid red");
		$("#end").css("border", "2px solid red");
		return false;
	}else{
		cal_hours_wage(); //计算工时工资
	}
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
	}
	return true;	
	
}


/**tab2 dialog validate
* (1) total == cash + card + online + prepaid - refund
* (2) cash + card + online + prepaid == turnover + product sales
*/
function cashflowValidation()
{
	alert("cashflowValidation");
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
var records = [] , records_raw=[];

//--------------------------------------Tab1 主体显示表格------------------------------------------------------------------------
$(function () {
	 
	var  orderIdClicked="";   
	
	jsGrid.loadStrategies.DirectLoadingStrategy.prototype.finishDelete = function (deletedItem, deletedItemIndex) {
		console.log(deletedItem);
		console.log(deletedItem.Timestamp); //

		var grid = this._grid;
		grid.option("data").splice(deletedItemIndex, 1);
		grid.refresh();
	};

	$("#jsGrid").jsGrid({
		height : "auto",
		width : "100%",

		filtering: false,
		//sorting : false,
		sorting: true,
		editing: false,
		//inserting: false,
		/**/
		autoload : true,
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
			var msg="The entry ID: \n\n" +"#"+ item.id + ", " + item.date + "," + item.shop_name + ", " + item.title + ", " + item.display_name +  "\n"
			+ "will be DELETED. \n\n Are you sure?";
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
				//location.reload(false);//刷新页面
				return ("Canceled. Nothing happened.") ;		
				
			}	
		},
		onItemInserted : function (args) {
			//$("#jsGrid").jsGrid("refresh");

			$("#jsGrid").jsGrid("reset");
			alert("Added!");
		},

		controller : {
			loadData : 
			function () {
				var d = $.Deferred();
                var u=$(location).attr('href'); 
				var id=u.substring(u.length-2,u.length-1);// get shop id from url
				
				$.ajax({
					
					url : phpUrl+"dailyRecordsBoss.php",
					dataType : "json"
				})
				.done(function (response) {
					
					var i = response.length;
					records_raw=response; 
					console.log("records raw: ");
					console.log(records_raw);
					$(response).each(
						function () {
							r = response[--i]; //one entry//
						
							var stl = 0;//不同产品的售价和
							for (var j = 0; j < (r.sales.split(',')).length; j++) 
							{
								stl += parseFloat(((r.sales.split(',')))[j]) || 0 ;
							}
							
							paidFlag=(r.if_paid==='1')? 'Yes': 'No';//是否已付
							
							var row = 
							{
								"id": r.id,
								"date" : r.date,
								"shop_name" : r.name, // branch name
								"title" : r.title,
								"user_id": r.employee_id, 
								"display_name" : r.display_name,
								"start_time" : r.start_time,
								"end_time" : r.end_time,
								"wk_hours" : r.wk_hours,
								"min_hrs" : r.min_hrs,
								"pay_rate" : r.pay_rate, // 这里要判断是那个rate，又可能rate已经改了。
								"pay_type" : r.pay_type,
								"turnover" : r.turnover,
								"sales"    : stl.toFixed(2),							
								//"threshold" : r.bonus_threshold+";"+r.bonus_threshold_rate,
								"wage" : r.wage,
								"ot_hours": r.ot_hours,
								"ot_rate": r.ot_rate,
								
								"if_paid": paidFlag //show yes or no later in js script below						
								 
							};
								
							records.push(row); 
						}
					); // end of $(response).each()
					d.resolve(records);					
				})
				.fail(function(){
					console.log("jsGrid load data fail.");
				});
				
				return d.promise();
				
			}//end of function
			
		
		},
		
	 
		fields : 
		[ 
			{
				name : "date",
				css:"print-title",
				title : "Date",
				type : "text",
				align : "center",
			    filtering : false,
				width : "auto",
				autosearch : true
				 
			}, 
			{
				name : "shop_name", //name对应数据库中字段
				css:"print-title",
				title: "Branch",
				type : "text",
				align : "center",
				width : "auto" ,
				autosearch : true
				
			}, 
			{
				name : "display_name",
				css:"print-title",
				width : "auto",
				title: "Employee",
				type : "text",
				align : "center",				
				autosearch : true
				 
			}, 
			{
				name : "title",
				title: "Department",
				css:"print-title",
				width : "auto",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
			    autosearch : true
			},	 		 
			{
				name : "wk_hours",
				title: "Service Hour",
				css:"print-title",
				width : "70",
				type : "text",
				editing: false,
				align : "center",
				autosearch : false,
				//width : "auto",
				filtering : false 
			},
			{
				name : "min_hrs",
				title: "Mini Hour",
				css:"print-title",
				width : "auto",
				type : "text",
				editing: false,
				align : "center",
				autosearch : false,
				//width : "auto",
				filtering : false 
			},
			{
				name : "pay_type",
				title: "Pay Type",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			},
			{
				name : "pay_rate",
				title: "Pay Rate",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			},			
			{
				name : "ot_rate",
				title: "OT Rate",
				css:"print-title",			
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto",
				filtering : false 
			},			
			{
				name : "ot_hours",
				title: "OT Hours",
				css:"print-title",			
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto",
				filtering : false 
			},	
			{
				name : "sales",
				title: "Product Sales",
				css:"print-title",
				width : "auto",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			},
			{
				name : "turnover",
				title: "Turnover",
				css:"print-title",
				width : "100",
				type : "text",
				align : "center",
				//width : "auto" ,
				autosearch : false,
				filtering : false
				
			}, 			
			/*{
				name : "wage",
				title : "Wages",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				//width : "auto",
				filtering : false 
			}, */
			{
				name : "if_paid",
				//css: "caption",
				title : "Paid",
				css:"print-title",
				width : "50",
				editing: false, 
				type : "text",
				align : "center",
				//width : "auto",
				autosearch : true,
				sorter: "string", // sort as string.
				filtering : false
			}

		]

	});

	//对应上方options
	$(".config-panel input[type=checkbox]").on("click", function() {
        var $cb = $(this);
        $("#jsGrid").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
		
    });			
});
 
//-------ceshi 测试
$(function() {
  // Handler for .ready() called.
  $(".dropdown > span").on("click", function () {
										console.log($(this));
										//update status icon and color
										if(r.if_paid==='Yes')
										{
											$(this).attr("class", "icon-cross").css({
												'font-size' : "1em",
												'color' : "#f1f1f1" //it's grey
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
});//-------ceshi

/*工时计算含参数*/
function cal_hrs(start,end) {
	
	var time1 = start.split(':'), time2 = end.split(':');
	
	if(start < end)
	{ 
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
		return hours;
         //$("#wages").val((hours* parseFloat($("#hour_rate_val").text())).toFixed(2));
		 
	}
	else if(start == end)
	{
		return 0;
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



//提取符合条件的数据
function array_filtered(data_copy,filters)
{	
	data_filtered=[];
	
	for(i=0;i<data_copy.length;i++)
	{
	
		//data.items.splice(1, 3); // Removes three items starting with the index 1,
		
		//console.log('data_copy[i]:');
		//console.log(data_copy[i]);
		var start,end;
		if(filters.start_date_filter > filters.end_date_filter)
		{
			start=filters.end_date_filter;
			end=filters.start_date_filter;
		}
		else
		{
			start=filters.start_date_filter;
			end=filters.end_date_filter;
		}
		console.log("filters.usrid_filter="+filters.usrid_filter+", data_copy[i].user_id="+data_copy[i].user_id);
		if(filters.usrid_filter===data_copy[i].user_id) // data.id 要添加到records里，数据库返回值里有id吗
		{
			console.log("user id filtered as below:");
			console.log(data_copy[i]);
			if(data_copy[i].date>=start &&  data_copy[i].date<=end)
			{
				//data.splice(i, 1); // Removes 1 items starting with the index 1,
				data_filtered.push(data_copy[i]);
			}
			
		}			
	}
		
	console.log("array_filtered() return data as below: ");
	console.log(data_filtered);
	return data_filtered;
}

//生成所有人的工资单
function printAllPayslip()
{
	//alert("所有人的工资单");
	// 按分店id循环输出
	// 按employee id 依次按日期顺序输出 到 div #payslip4all
	// 输出项目包括：branch, department, 上下班时间，service（massage）时间 和 最低保证工作时间，基本工资，turnover，其对应的bonus，product sales, 其对应的comission, 加班小时，加班费.
	// 每输出完一个人，显示总工资：基本工资 + bonus + comission + 加班费
	
	//可利用数据： records_raw 包含所有数据。
	var records_raw_payslip = records_raw;
  
	//首先对 records_raw_payslip 按照 employee id 由小到大顺序排序，因为有跨店的情况。
	records_raw_payslip.sort(function(a,b){
		var aEmployee_id = a.employee_id ;
		var bEmployee_id = b.employee_id; 						
		return ((aEmployee_id < bEmployee_id) ? -1 : ((aEmployee_id > bEmployee_id) ? 1 : 0)); //按照branch name 由小到大顺序排序	
	});
	
 
	var basic_wg=0, bonus = 0,comission = 0, ot_wage=0; //这些变量需要写函数来单独计算 11-07
	var basic_wg_sum =0, bonus_sum = 0,comission_sum = 0, ot_wage_sum =0, total=0; 
	var Employee_id = "";
	var payslipCol='';
	var payslipRow="", payslipTitle='<div class="row blue">'
	+ '<div class="col-sm-1">Name & ID</div>'
	+ '<div class="col-sm-1">Branch & Depart</div>'
	+ '<div class="col-sm-1">Date</div>'
	+ '<div class="col-sm-1">Clock-in<br/>Clock-out</div>'
	+ '<div class="col-sm-1">Service<br/>Hour</div>'
	+ '<div class="col-sm-1">Basic<br/>Wage</div>'
	+ '<div class="col-sm-1">Turnover</div>'
	+ '<div class="col-sm-1">Bonus</div>'
	+ '<div class="col-sm-1">Product<br/>Sales</div>'
	+ '<div class="col-sm-1">Comission</div>'
	+ '<div class="col-sm-1">OT Hour</div>'
	+ '<div class="col-sm-1">OT Wage</div>'
	+ '</div><br/>' ;//table header here
	
	var payslipRowTotal="";
	var bgColor="";//set row backgroud color
	var hr='';
	
	$(records_raw_payslip).each(function(index){
		//对每一行记录
		if(records_raw_payslip[index].if_paid==='1')
		{
			return true; //如果已经付过工资了，则跳过，进行下一条计算。
		}
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].display_name +" #"+ records_raw_payslip[index].employee_id +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].name +"<br/>"+ records_raw_payslip[index].title +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].date +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].start_time +"<br/>"+ records_raw_payslip[index].end_time +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].wk_hours +'</div>';
		//payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].min_hrs +'</div>';
		basic_wg=cal_basic_wage(records_raw_payslip[index]);
		basic_wg_sum += parseFloat(basic_wg);
		bonus = cal_bonus(records_raw_payslip[index]);
		bonus_sum += parseFloat(bonus);
		comission = cal_comission(records_raw_payslip[index]);
		comission_sum += parseFloat(comission);
		ot_wage = cal_ot_wage(records_raw_payslip[index]);
		ot_wage_sum += parseFloat(ot_wage);
		payslipCol+='<div class="col-sm-1">'+ basic_wg +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].turnover +'</div>';
		payslipCol+='<div class="col-sm-1">'+ bonus +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].sales.replace(/,/g,"<br/>") +'</div>';
		payslipCol+='<div class="col-sm-1">'+ comission +'</div>';
		payslipCol+='<div class="col-sm-1">'+ records_raw_payslip[index].ot_hours +'</div>';
		payslipCol+='<div class="col-sm-1">'+ ot_wage +'</div>';
		
		//是否安装header
		if(index===0 || records_raw_payslip[index].employee_id !== records_raw_payslip[index-1].employee_id){
			payslipRow += payslipTitle ;
		}
		
		//set row backgroud color
		if(index % 2 === 0)
		{
			
			bgColor="";
		}
		else{
			bgColor="";
		}
		
		//if append <hr/> to the end of every employee 
		if(index===$(records_raw_payslip).length-1)
		{
			hr='<hr/>';
			total= basic_wg_sum+bonus_sum+comission_sum+ot_wage_sum;
			payslipRowTotal='<div class="row red">'
				+ '<div class="col-sm-1">'+ " " +'</div>'
				+ '<div class="col-sm-1">'+ " " +'</div>'				
				+ '<div class="col-sm-1">'+ "Total Wage :" +'</div>'
				+ '<div class="col-sm-1" style="font-size:1.1em;font-weight: bold;">£'+ total.toFixed(2) +'</div>'
				+ '<div class="col-sm-1">'+ "=" +'</div>'
				+ '<div class="col-sm-1">£'+ basic_wg_sum.toFixed(2) +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ bonus_sum.toFixed(2)  +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ comission_sum.toFixed(2)  +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ ot_wage_sum.toFixed(2) +'</div>'
				+ '</div>' ; //total basic wage, bonus, comission, ot wage, here
		}
		else if(records_raw_payslip[index].employee_id!==records_raw_payslip[index+1].employee_id)
		{
			hr='<hr/>';
			total= basic_wg_sum+bonus_sum+comission_sum+ot_wage_sum;
			payslipRowTotal='<div class="row red">'
				+ '<div class="col-sm-1">'+ " " +'</div>'
				+ '<div class="col-sm-1">'+ " " +'</div>'				
				+ '<div class="col-sm-1">'+ "Total Wage :" +'</div>'
				+ '<div class="col-sm-1" style="font-size:1.1em;font-weight: bold;">£'+ total.toFixed(2) +'</div>'
				+ '<div class="col-sm-1">'+ "=" +'</div>'
				+ '<div class="col-sm-1">£'+ basic_wg_sum.toFixed(2) +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ bonus_sum.toFixed(2)  +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ comission_sum.toFixed(2)  +'</div>'
				+ '<div class="col-sm-1">'+ "+" +'</div>'
				+ '<div class="col-sm-1">£'+ ot_wage_sum.toFixed(2) +'</div>'
				+ '</div>' ; //total basic wage, bonus, comission, ot wage, here
				
				basic_wg_sum =0;
				bonus_sum = 0;
				comission_sum = 0;
				ot_wage_sum =0;
		}
		else{
			hr='<br/>'; //同一个人的不同时间记录换行即可不用分割线
		}
		payslipRow +='<div class="row '+ bgColor +'">'+ payslipCol +'</div>'+ payslipRowTotal +hr; //组装成1行。
		
		payslipCol='';
		payslipRowTotal='';
		
		
		
	});//对每一行记录
	
	$("#payslip4all").append(payslipRow);
	return false;//避免提交数据库，导致页面又不必要的刷新一次。
}

//filter dailyrecords for Boss eric  
function filterRecords()
{
	//剪裁record数组，使它符合filter条件
	records_filtered=records; 
	
	employeeId=$("#name-filter").val();
	startDate=$("#start-date-filter").val();
	endDate=$("#end-date-filter").val();
	
	filters=
	{
		'usrid_filter': employeeId,
		'start_date_filter': startDate,
		'end_date_filter': endDate
	};
	
	//过滤出符合条件的数组
	records_filtered=array_filtered(records_filtered,filters);
	
	//对相同同条件的记录进行合并. 目前还没做。不用做了。
	//to do sth here.
	
	//加载records_filtered到表格#jsGrid	
	$("#jsGrid").jsGrid({
		height: "auto",
		width: "100%",
		sorting: true,
		paging: false,
		autoload: true,
		controller: {
			loadData: function(){
				var records_filtered_desc_date = records_filtered;
				records_filtered_desc_date.sort(function(a,b){
					var aDate = a.date ;
					var bDate = b.date; 						
					return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); //逆序排序	
				});
				return records_filtered_desc_date;
			}			 
		},
		 
		fields : 
		[
			
			{
				name : "date",
				css:"print-title",
				title : "Date",
				type : "text",
				align : "center",
			    filtering : false,
				width : "auto",
				autosearch : true
				 
			}, 
			{
				name : "shop_name", //name对应数据库中字段
				css:"print-title",
				title: "Branch",
				type : "text",
				align : "center",
				width : "auto" ,
				autosearch : true
				
			}, 
			{
				name : "display_name",
				css:"print-title",
				width : "auto",
				title: "Employee",
				type : "text",
				align : "center",				
				autosearch : true
				 
			}, 
			{
				name : "title",
				title: "Department",
				css:"print-title",
				width : "auto",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
			    autosearch : true
			},	
			{
				name : "start_time",
				title : "Clock-in",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				//width : "auto",
				filtering : false 
			},
			{
				name : "end_time",
				title : "Clock-out",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				//width : "auto",
				filtering : false 
			},
			{
				name : "wk_hours",
				title: "Service Hour",
				css:"print-title",
				width : "auto",
				type : "text",
				editing: false,
				align : "center",
				autosearch : false,
				width : "auto",
				filtering : false 
			}, 
			{
				name : "pay_rate",
				title: "Pay Rate",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			},			
			{
				name : "pay_type",
				title: "Pay Type",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			}, 
			{
				name : "sales",
				title: "Product Sales",
				css:"print-title",
				width : "70",
				type : "text",
				align : "center",
				autosearch : true,
				//width : "auto",
				filtering : false 
			},
			{
				name : "turnover",
				title: "Turnover",
				css:"print-title",
				width : "100",
				type : "text",
				align : "center",
				//width : "auto" ,
				autosearch : false,
				filtering : false
				
			}, 
		 			
			{
				name : "if_paid",
				//css: "caption",
				title : "Paid",
				css:"print-title",
				width : "50",
				editing: false, 
				type : "text",
				align : "center",
				//width : "auto",
				autosearch : true,
				sorter: "string", // sort as string.
				filtering : false
			} /*,
			{
				type : "control",
				css:"no-print", //这样打印时不显示
				 
				editButton : false,
				deleteButton : false,//为了展示，先暂时关闭
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
			}*/

		]

		
	});

	//show breakdown in breakdown area: #wage_breakdown
	show_breakdown();
	
	return false;//防止提交表格。不要写成true
}

//根据产品id,dt(date) , 返回对应该产品的sales rate。用来计算comission.
var sales_rate;
function get_sales_rate()
{
 
	 
	var querysql="select product_id, effective_date, sales_rate from  wp_shop_product_rate "; //选择所有product rate 记录
 			
	//var whereclause=" where product_id= "+id +" and effective_date <= '2016-10-22'";
	//querysql = querysql + whereclause;
	//querysql = "SELECT effective_date, sales_rate FROM wp_shop_product_rate WHERE product_id= "+id;
	//console.log(querysql);
	var rate=0;
	 
	$.ajax({
			type:'POST',
			data: {'query':querysql},
			//async:false,
			url : phpUrl+"getData.php", // read wp_shop_bonus table  
			dataType : "json"
	})
	.done(function(data){
		// data 是返回所有 id = product id
		// 所以对data进行逆序排序，取第1个元素，就是离记录日期最近的product rate
		// 逆序排列 data 
		data.sort(function(a,b){
			var aDate = a.effective_date ;
			var bDate = b.effective_date; 						
			return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); //逆序排序	
		});
		sales_rate = data;
		 
		
		console.log("sales_rate值: ");
		
		console.log(sales_rate);
	
		
	})
	.fail(function(data){
		console.log("product_rate table: ");
		
		console.log(data);
		rate= 0;
		
	});
	 
}


//单独计算基本工资 
//records_raw_payslip_row 是单独一行记录
function cal_basic_wage(records_raw_payslip_row)
{
	//基本工资变量
	var basic_wage =0, hours=0;
	
	if(records_raw_payslip_row.pay_type==="daily")
	{					 
		basic_wage = parseFloat(records_raw_payslip_row.pay_rate); // payRate x 1 等于没乘，所以直接赋值
		 
	}
	else if(records_raw_payslip_row.pay_type==="hourly")//小时工的情况比较复杂：有可能即做小时工，又做massage
	{
					var hours=cal_hrs(records_raw_payslip_row.start_time, records_raw_payslip_row.end_time);//计算上班小时数
					
					//如果service hours > 0, 则认为此员工从事massage。
					//计算基本工资时，要计算2部分。
					if(parseFloat(records_raw_payslip_row.wk_hours) > 0)//公式3的计算.这里用wk_hours(service hour)>0来区分是否做了massage. 如果>0,则做了。否则没有做。
					{
						//did a massage job
						//console.log("最低保证时间== "+records_filtered[i].min_hrs);//专指做massage
						var x = parseFloat(records_raw_payslip_row.min_hrs);//许诺最少的按摩时间
						var y = parseFloat(records_raw_payslip_row.wk_hours);//实际的按摩时间=service hour
						
						if(y<x)
						{//实际工作时间 < 最低保证时间
							//console.log("最低保证时间： "+x);
							basic_wage = x * records_raw_payslip_row.pay_rate;
						}
						else{//实际工作时间 >= 最低保证时间
							basic_wage = y * records_raw_payslip_row.pay_rate;
						}
						//这里还要再剥去massage时间，计算出按小时工计算的工资。
						if(hours > parseFloat(records_raw_payslip_row.wk_hours)) //如果上班时间大于massage时间
						{
							//按小时工 计算的工资
							basic_wage += (hours-parseFloat(records_raw_payslip_row.wk_hours)) * parseFloat(records_raw_payslip_row.pay_rate);
							
						} 
						
					}
					else{
						//如果不做massage，即一般小时工，则简单：hourly rate x hours
						basic_wage = parseFloat( records_raw_payslip_row.pay_rate) * hours;
						
					}
	}
	//如果是 pay-type 是 massage 的员工
	else if(records_raw_payslip_row.pay_type==="massage")
	{
					 
					//如果service hours（wk_hours） > 0, 则认为此员工从事massage。					
					if(parseFloat(records_raw_payslip_row.wk_hours) >= 0)//公式3的计算.
					{
						//did a massage job
						//console.log("最低保证时间== "+records_raw_payslip_row.min_hrs);//专指做massage
						x = parseFloat(records_raw_payslip_row.min_hrs);//许诺最少的按摩时间
						y = parseFloat(records_raw_payslip_row.wk_hours);//实际的按摩时间=service hour
						
						if(y<x)
						{//实际工作时间 < 最低保证时间
						
							basic_wage = x * parseFloat(records_raw_payslip_row.pay_rate);
						}
						else{//实际工作时间 >= 最低保证时间
							basic_wage = y * parseFloat(records_raw_payslip_row.pay_rate);
						}
						
					}
					else{						 
						console.log("massage员工的wk_hours小于0.");						
					}
	}
	return basic_wage.toFixed(2);
}

//单独计算 Bonus , 依据是每个人每天的创收 turnover. 
//records_raw_payslip_row 是单独一行记录
function cal_bonus(records_raw_payslip_row)
{
	var bonus=0;
	var bonus_sum=0;
	
	var bonus_band=bonus_rec.sort(function(a,b){
			var aDate = a.effective_date ;
			var bDate = b.effective_date; 						
			return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); //时间逆序排序	
		});	
	//get bonus table 最好是全局变量
	console.log("bonus_rec记录：");
	console.log(bonus_rec);
	
	//计算bonus		
	//对每一个记录进行下面计算	
	var turnover= parseFloat(records_raw_payslip_row.turnover) ;
			
	$.each(bonus_band,function(index, item)//bonus_band已经是按时间逆序排列了。但是没有去掉和employee id 不符合的记录
	{
				if(item.usrid !== records_raw_payslip_row.employee_id 
					|| ( item.branch_id !== records_raw_payslip_row.name ) 
					|| (item.depart_id !== records_raw_payslip_row.title))
				{//去掉ID不符合的记录
					return true;
				}
				if(records_raw_payslip_row.date >= item.effective_date )//如果 records 日期 > threshold 日期
				{//则就用当前日期对应的threshold
					if(turnover > parseFloat(item.bonus_threshold))
					{
						bonus = (turnover- parseFloat(item.bonus_threshold)) * parseFloat(item.bonus_threshold_rate);
						 
						return false; //jump out each loop. //return false; skip to next iteration in jQuery.each() 
					}
					
				}
				else //移到下一个threshold的日期，进行比较。
				{
					console.log("不参与计算： turnover , item.bonus_threshold:");
					console.log(turnover+","+item.bonus_threshold);
				}
				 
	});	
	return bonus.toFixed(2);
}

////单独计算 Comission  
//records_raw_payslip_row 是单独一行记录
function cal_comission(records_raw_payslip_row)
{
	var comission=0;
	
	//提成计算(i.e,: commision rate / product sales rate)

	var sales_array=records_raw_payslip_row.sales.split(',');
	var rate=0;
				for(j=0;j<sales_array.length;j++)
				{
					if(parseFloat(sales_array[j])>0  ) //只显示sales大于0的
					{
						
						//sales_rate是全局变量，已经按时间逆序排序。存放sales rate 表的数据。
						$(sales_rate).each(function (index){
							//console.log("product id: "+sales_rate[index].product_id + " , rate: "+ sales_rate[index].sales_rate + " , sales_rate[index].effective_date: "+sales_rate[index].effective_date);
							//j 标定着产品顺序，product id 从2开始编号。所以加2
							//这里有个弱点，如果产品id出现跳号，那么有问题。
							if((sales_rate[index].product_id==(j+2)) && (records_raw_payslip_row.date >= sales_rate[index].effective_date))
							{
								rate= sales_rate[index].sales_rate;
								 
								return false;
							}
						});
					 
						comission += parseFloat(rate) * parseFloat(sales_array[j]);	
					}
							
				}
	
	return comission.toFixed(2);
}

//单独计算 OT Wage 加班费  
//records_raw_payslip_row 是单独一行记录
function cal_ot_wage(records_raw_payslip_row)
{
	var ot_wage=0;
	
	ot_wage = parseFloat(records_raw_payslip_row.ot_rate) * parseFloat(records_raw_payslip_row.ot_hours);
	
	return ot_wage.toFixed(2);
}

//show breakdown in breakdown area 核心函数
function show_breakdown()
{
	$("#basic_wage_pannel").attr({class: "panel panel-primary"});//show wage pannel
	$("#bonus_pannel").attr({class: "panel panel-success"});//show bonus pannel
	$("#commission_pannel").attr({class: "panel panel-warning"});//show commssion pannel
	$("#total_wage_pannel").attr({class: "panel panel-danger"});//show total pannel
	
	console.log( "show_breakdown: records_filtered: " );
	console.log( records_filtered );
	
	//基本工资变量
	var wage1_sum=0,days=0,hours=0;
	var basic_wage_breakdown="";
	
	//奖金计算变量
	var bonus_sum=0;
	var bonus_breakdown="", bonus_flag=0 ;
	var bonus_band;	
	//获取wp_shop_bonus数据，以便于奖金计算
	var data_array={
		'id': $("#name-filter").val(),//employee id
		
	};
	//console.log(data_array);
	
	$.ajax({
			type: 'POST',
			url : phpUrl+"getBonusTable.php",
			data: data_array,
			dataType : "json"
	})
	.done(function (response){
		len = response.length;
		console.log("response un-sorted: ");
		console.log(response);
		// 逆序排列 response 
		response.sort(function(a,b){
			var aDate = a.effective_date ;
			var bDate = b.effective_date; 						
			return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); //逆序排序
						
		});
		console.log("bonus_band 奖金阈值 sorted as below in desc date order: ");
		bonus_band=response;
		console.log(bonus_band);
		//records_filtered排序
		records_filtered.sort(function(a,b){
			var adate = a.date ;
			var bdate = b.date; 						
			return ((adate < bdate) ? 1 : ((adate > bdate) ? -1 : 0)); //逆序排序
						
		});
		console.log("逆序排序的records_filtered：");
		console.log(records_filtered);
		
		//2.计算bonus		
		for(var i=0;i<records_filtered.length;i++)//对每一个符合条件的记录进行下面计算
		{
			var turnover= parseFloat(records_filtered[i].turnover) ;
			
			$.each(bonus_band,function(index, item)//bonus_band已经是按时间逆序排列了。但是没有去掉employee id 不符合的记录
			{
				if(item.employee_id!==records_filtered[i].user_id)
				{//去掉ID不符合的记录
					return true;
				}
				if(records_filtered[i].date >= item.effective_date )//如果 records 日期 > threshold 日期
				{//用当前日期对应的threshold
					if(turnover > parseFloat(item.bonus_threshold))
					{
						bonus_sum += (turnover- parseFloat(item.bonus_threshold)) * parseFloat(item.bonus_threshold_rate);
						console.log("bonus_sum: ");
						console.log(bonus_sum);
						
						bonus_flag=1;
						//为了显示用，不参与计算
						//bonus_breakdown += "Bonus threshold " + "£"+ item.bonus_threshold + " , Bonus threshold rate: " + item.bonus_threshold_rate;
						bonus_breakdown +="("+ turnover.toFixed(2) +" - " + item.bonus_threshold + ")" + " x " + item.bonus_threshold_rate + " + ";
						return false; //jump out each loop. //return false; skip to next iteration in jQuery.each() 
					}
					else
					{
						console.log("不参与计算： turnover , item.bonus_threshold:");
						console.log(turnover+","+item.bonus_threshold);
					 
					}
					
					
				}
				else //移到下一个threshold的日期，进行比较。
				{
					console.log("不参与计算： turnover , item.bonus_threshold:");
					console.log(turnover+","+item.bonus_threshold);
				}
				 
			});
			
		}
	 
		
		//2. output Bonus		
		$(".bonus_amount").text("£"+bonus_sum.toFixed(2));
		$("#bonus .calculation").text(bonus_breakdown.substring(0,bonus_breakdown.length-3 ) + " = " + bonus_sum.toFixed(2)); 
		//4. output total_wage_amount
	    $(".total_wage_amount").text("£"+(wage1_sum+bonus_sum+commission_sum).toFixed(2));
		$("#total_wage .calculation").text("= £"+wage1_sum.toFixed(2)+" + £"+commission_sum.toFixed(2)+" + £"+bonus_sum.toFixed(2));
	})
	.fail(function(response){
		console.log("get bounus threshold fail from db.");
		console.log( response );
	});
	 
	
	//提成计算变量
	var commission_sum=0;
	var commission_breakdown="", commission_date="" ;
	
	//总工资计算变量
	var total_wage=0;
	var total_wage_breakdown="" ;
	
    //计算开始	
	for(i=0;i<records_filtered.length;i++)
	{
			if(records_filtered[i].if_paid==='No') //注意如果paid==Yes，是没有后面计算的
			{
				//1.基本工资计算
				// 
				var payRate = records_filtered[i].pay_rate;
				if(records_filtered[i].pay_type==="daily")
				{					 
					pay_rec.sort(function(a,b){
						var aDate = a.effective_date ; 
						var bDate = b.effective_date; 						
						return ((aDate < bDate) ? 1 : ((aDate > bDate) ? -1 : 0)); //按日期 逆序排序
									
					});
					
					console.log("pay rec:");
					console.log(pay_rec);
					$(pay_rec).each(function (index)
					{
						 
						if((pay_rec[index].pay_type=== 'daily') && (records_filtered[i].shop_name === pay_rec[index].branch_name) 
							&& (records_filtered[i].title === pay_rec[index].department_name)
							&& (records_filtered[i].user_id === pay_rec[index].employee_id))
						{
							if(records_filtered[i].date >= pay_rec[index].effective_date)
							{
								payRate = pay_rec[index].pay_rate;
								console.log("因为找到 pay_rec ");
								
								return false;//跳出循环，因为找到了。
							}
						}
						else{
							;
						}
					});
					
					
					wage1_sum += parseFloat(payRate); // payRate x 1 等于没乘，所以直接赋值
					days++;
					basic_wage_breakdown += "£"+ payRate + " + ";//为了显示用，不参与计算
				}
				else if(records_filtered[i].pay_type==="hourly")//小时工的情况比较复杂：有可能即做小时工，又做massage
				{
					var hours=cal_hrs(records_filtered[i].start_time,records_filtered[i].end_time);//计算上班小时数
					console.log("工种： "+records_filtered[i].title);
					
					//如果service hours > 0, 则认为此员工从事massage。
					//计算基本工资时，要计算2部分。
					if(parseFloat(records_filtered[i].wk_hours) > 0)//公式3的计算.这里用wk_hours(service hour)>0来区分是否做了massage. 如果>0,则做了。否则没有做。
					{
						//did a massage job
						console.log("最低保证时间== "+records_filtered[i].min_hrs);//专指做massage
						x = parseFloat(records_filtered[i].min_hrs);//许诺最少的按摩时间
						y = parseFloat(records_filtered[i].wk_hours);//实际的按摩时间=service hour
						
						if(y<x)
						{//实际工作时间 < 最低保证时间
							//console.log("最低保证时间： "+x);
							wage1_sum += x * parseFloat(records_filtered[i].pay_rate);
							basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " + records_filtered[i].min_hrs +"(min hours)" +" + ";//为了显示用，不参与计算
						}
						else{//实际工作时间 >= 最低保证时间
							wage1_sum += y * parseFloat(records_filtered[i].pay_rate);
							basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " + records_filtered[i].wk_hours +"(h)" +" + ";//为了显示用，不参与计算
						}
						//这里上班总时间还要再剥去massage时间，计算出按小时工计算的工资。
						if(hours > parseFloat(records_filtered[i].wk_hours)) //如果上班时间大于massage时间
						{
							wage1_sum += (hours - parseFloat(records_filtered[i].wk_hours)) * parseFloat(records_filtered[i].pay_rate);
							basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " +"["+ hours +" - "+ records_filtered[i].wk_hours +"(massage hrs)]" +" + ";//为了显示用，不参与计算
						
						} 
						
					}
					else{
						//如果不做massage，即一般小时工，则简单：hourly rate x hours
						wage1_sum += parseFloat( records_filtered[i].pay_rate) * hours;
						//hours+=parseFloat(records_filtered[i].wk_hours);
						console.log(records_filtered[i].title);
						basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " + hours +"(h)" +" + ";//为了显示用，不参与计算
					}
				}
				//如果是 pay-type 是 massage 的员工
				else if(records_filtered[i].pay_type==="massage")
				{
					console.log("工种： "+records_filtered[i].title);
					
					//如果service hours（wk_hours） > 0, 则认为此员工从事massage。					
					if(parseFloat(records_filtered[i].wk_hours) >= 0)//公式3的计算.
					{
						//did a massage job
						console.log("最低保证时间== "+records_filtered[i].min_hrs);//专指做massage
						x = parseFloat(records_filtered[i].min_hrs);//许诺最少的按摩时间
						y = parseFloat(records_filtered[i].wk_hours);//实际的按摩时间=service hour
						
						if(y<x)
						{//实际工作时间 < 最低保证时间
							//console.log("最低保证时间： "+x);
							wage1_sum += x * parseFloat(records_filtered[i].pay_rate);
							basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " + records_filtered[i].min_hrs +"(min hours)" +" + ";//为了显示用，不参与计算
						}
						else{//实际工作时间 >= 最低保证时间
							wage1_sum += y * parseFloat(records_filtered[i].pay_rate);
							basic_wage_breakdown += "£"+ records_filtered[i].pay_rate + " x " + records_filtered[i].wk_hours +"(h)" +" + ";//为了显示用，不参与计算
						}
						
					}
					else{						 
						console.log("massage员工的wk_hours小于0.");						
					}
				}
				
				//2.奖金计算
				//nothing here.
				
				
				
				//3.提成计算(i.e,: commision rate / product sales rate)
				//var id=records_filtered[i].id;
				var sales_array="";
				$(records_raw).each(function(index){
					if(records_raw[index].id=== records_filtered[i].id)
					{
						sales_array =  records_raw[index].sales;
						sales_array=sales_array.split(',');
						return false;
					}
					
				});
				
				var rate=0;
				for(j=0;j<sales_array.length;j++)
				{
					//console.log("sales_array["+j+"]: "+ parseFloat(sales_array[j]));
						
					if(parseFloat(sales_array[j])>0  ) //只显示sales大于0的
					{
						//sales_rate 的值要根据 product id 来定
					  
						
						$(sales_rate).each(function (index){
							//console.log("product id: "+sales_rate[index].product_id + " , rate: "+ sales_rate[index].sales_rate + " , sales_rate[index].effective_date: "+sales_rate[index].effective_date);
							//j 标定着产品顺序，product id 从2开始编号。所以加2
							//这里有个弱点，如果产品id出现跳号，那么有问题。
							if((sales_rate[index].product_id==(j+2)) && (records_filtered[i].date >= sales_rate[index].effective_date))
							{
								rate= sales_rate[index].sales_rate;
								 
								return false;
							}
						});
					 
						commission_sum += parseFloat(rate) * parseFloat(sales_array[j]);	
						
					    commission_breakdown += "£" +sales_array[j]+ " x "+ rate + " + ";
					}
							
				}
				
				
			}
		 
	}
	//1. output basic wage
	basic_wage_breakdown=basic_wage_breakdown.substring(0,basic_wage_breakdown.length-3);
	basic_wage_breakdown += " = " + "£"+ wage1_sum.toFixed(2); 
	$(".basic_wage_amount").text("£"+wage1_sum.toFixed(2));
	$("#basic_wage .calculation").text(basic_wage_breakdown);
	 
	//2. output Bonus	
	
	//$(".bonus_amount").text("Bonus : "+"£"+bonus_sum.toFixed(2));
	//$("#bonus .calculation").text(bonus_breakdown); 
	 
	//3. output commission
	commission_breakdown=commission_breakdown.substring(0,commission_breakdown.length-3);
	commission_breakdown += " = " + "£"+ commission_sum.toFixed(2);
	$(".commission_amount").text("£"+commission_sum.toFixed(2));
	$("#commission .calculation").text(commission_breakdown);
	
	//4. output total_wage_amount
	$(".total_wage_amount").text("£"+(wage1_sum+bonus_sum+commission_sum).toFixed(2));
	$("#total_wage .calculation").text("= £"+wage1_sum.toFixed(2)+" + £"+commission_sum.toFixed(2)+" + £"+bonus_sum.toFixed(2));
}

//get photo of the employee 100x100
function get_profile(x,y,id,user_id) 
{
	$.ajax({
			//type: 'GET', //这行不用写
			url: phpUrl+"getProfile.php",
			data: {userid: $(user_id).val()},
			dataType: "json"
	})
	.done(function (data)
	{
		//data = JSON.parse(data);// The JSON you are receiving is in string. You have to convert it into JSON object .
		
		console.log(data);
		console.log(data.img_html);
		$(id).children().remove();		
		$(id).append(data.img_html);
		$(id+" img").attr({"class": "img-circle img-responsive", "style":"margin: 0 0;", "width":x,"height":y});
		//assign value to label Hour Rate
		$("#hour_rate_val").text(data.payRate);
		$("#depart_name").val(data.department);
	})
	.fail(function (data){
		console.log("load pic fail.");		
		console.log(data);
	});
	
}


//show detailed calculation steps
function show_breakdown_backup()
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
/* function  cal_bonus(){
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
} */

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

/* 打印jsgrid表格按钮
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
/* 打印jsgrid表格按钮
*
*/
function printDiv2(id) {
		
	$("#"+id).printArea();
	 
	
}



/* 输出jsgrid数据为CSV格式文件
*
**/
function exportCsv()
{
	var title = {
		"id": "Entry ID",
		"date" : "Date",
		"shop_name" : "Branch",
		"title" : "Department",
		"user_id": "User ID", 
		"display_name" : "Employee Name",
		"start_time" : "Clock In",
		"end_time" : "Clock Out",
		"wk_hours" : "Service Hour",
		"min_hrs" : "Min Hour",
		"pay_rate" : "Pay Rate",
		"pay_type" : "Pay Type",
		"turnover" : "Turnover",
		"sales"    : "Product Sales",
		"wage" : "Wage" ,
		"ot_hours" : "OT Hours" ,
		"ot_rate" : "OT Rate" ,
		"if_paid": "Paid" //show yes or no later in js script below	
	};
	var rec=records;
	rec.unshift(title);//插入标题title
	console.log("exportCsv data: ");
	console.log(rec);
	$.ajax({
		type: "POST",
		url: phpUrl+"export2CSV.php",
		data: {d:records}
	})
	.done( function(){
		alert("Export to CSV.");
	 
	    //$(this).attr('href','<?php echo get_site_url(); ?>/wp-content/themes/glow/export/exportData.csv').attr('target','_blank');
		//window.open('../export/exportData.csv');
		$("#exportDailyRecordsCSV").attr('class',"hidden");
		$("#downloadDailyRecordsCSV").attr('class',"");
	})
	.fail(function(){
		alert("Can't export to CSV. Please try later.");
		console.log("can't send data to php!");
	});
}

//保存Setting页面的关于Product Sales Rate 的设置
function saveSalesRate()
{
	var data_array={};
	$('[id^="prd_settings-"]')
	.each(function()
	{
		console.log($(this).attr('id'));
		var id= $(this).attr('id').replace('prd_settings-','');
		data_array[id]=$("#prd_settings-"+id).val().replace('/:/g','') +":"+ $("#rate_settings-"+id).val(); //用;作为名称和rate的分隔符，所以要先过滤掉名称里原有的;.
		
	});
	console.log(data_array);
 
	 
	$.ajax({
		type: "POST",
		url: phpUrl+"updateProductSalesRate.php",
		data: data_array  
	})
	.done(function ( ){
		alert("Saved!");
		console.log("data passed: ");
		console.log(data_array);
	 
	})
	.fail(function( ) {
		alert("Can't save the settings!");
		 
	});
 
}

//保存Setting页面的关于分店经理的设置
function saveBranchManager()
{
	var data_array={
		"1": $("#manager_setting-1").val(), 
		"2": $("#manager_setting-2").val(), 
		"3": $("#manager_setting-3").val()
	};
	$.ajax({
		type: "POST",
		url: phpUrl+"updateBranchManager.php",
		data: data_array  
	})
	.done(function ( ){
		alert("Saved!");
		console.log("manger id: ");
		console.log(data_array);
	 
	})
	.fail(function( ) {
		alert("Can't save the settings!");
		 
	});
}

var pay_rec = []; //记录今后修改的 pay rate
var bonus_rec = [];   //存放bonus threshold , threshold rate 

$().ready(function () {
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	  $("#jsGridTransaction").jsGrid("refresh");
	  $("#jsGrid_pay_rate").jsGrid("refresh"); //刷新Settings tab的 pay rate 表格
	  $("#jsGrid_prd_sale_rate").jsGrid("refresh"); //刷新Settings tab的 product sales rate 表格
	  $("#jsGrid_bonus_threshold").jsGrid("refresh"); //刷新Settings tab的bonus threshold 表格
	  
	});
	get_sales_rate();//提前获取product sales rate 方便后期计算
	$('#ord_ref').click(function () {
		order_add();
	});

	$("#orderPrintMoreBtn").css({
		'margin' : "0.2em 0 0.2em 25em",
		"width" : "10em"
	}).click(function () {});

	$("#orderPrintLessBtn").css({
		'margin' : "0.2em 0 0.2em 25em",
		"width" : "10em"
	}).click(function () {});

	/***********************************************************Tab2 grid*****************************************/
	//phpurl = phpUrl+"dailyCashflow.php"; // read wp_shop_cashflow table.
	var records_trans = [];
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
		 
		//db below here----------------------------
		controller : {
			loadData : function () {
				var d = $.Deferred();
				 
                //var u=$(location).attr('href'); 
				//var id=u.substring(u.length-2,u.length-1);// get shop id from url.局限：编号只能是个位数
				
				$.ajax({
					//data: {"shop_id":"all"},
					url : phpUrl+"dailyCashflowBoss.php", // read wp_shop_cashflow table.
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
						//console.log("r: "+r);
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
					console.log("records_trans: ");
					console.log(records_trans);
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
			/* {
				name : "id", // 对应数组row中的index
				title : "Entry ID",
				type : "text",
				align : "center",
				filtering : false,
			 
				width : "auto"
				
			},  */
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
	
	
	$(".config-panel input[type=checkbox]").on("click", function() {
        var $cb = $(this);
        $("#jsGridTransaction").jsGrid("option", $cb.attr("id"), $cb.is(":checked"));
    });
    /****************************************************Tab2 grid end**********************************************************/
	
	/**************************************************** Tab4 Settings Pay Rate, OT Rate, Min Hour **********************************************************/	
	$("#jsGrid_pay_rate").jsGrid({
		height : "auto",
		width : "100%",

		//filtering: true,
		sorting : true,
		//editing: true,
		//inserting: true,
		/**/
		autoload : true,
		pagerContainer : "#externalPager_pay_rate",
		paging : true,
		//pageLoading: true,
		pageSize : 10,
		pageIndex : 1,
		pageButtonCount : 5,
		/**/
		rowClick: function(args) { 

			//console.log(args.item.OrderID);
			orderIdClicked=args.item.OrderID;
			return args.item.OrderID;
		},
		deleteConfirm : function (item) {
			 
			var msg="The entry:\n\n " +"#"+ item.id + ","+ item.display_name +","+ item.branch_name +","+ item.department_name + ", .... \n\n will be DELETED. \n Are you sure?";
			var deleteFlag=0;
			
			var answer=confirm(msg);
			if (answer==true)
			{
				//php delete a row in table in db
				var tb="wp_shop_employee_payrate";
				$.ajax({
					type: "POST",
					url: phpUrl+"deleteData.php",  
					data: 
					{
						id: item.id,
						table: tb 
					}
				 
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
	 
		//db below here----------------------------
		controller : {
			loadData : function () {
				var d = $.Deferred();			 
           
				//var pay_rec = [];
			 
				var querysql="select * from wp_shop_employee_payrate";
				var querysql="select \
					usr.display_name, \
					loc.name branch_name, \
					dept.title department_name, \
					emp_pr.id, emp_pr.employee_id, emp_pr.pay_rate, emp_pr.pay_type, emp_pr.effective_date , emp_pr.ot_rate, emp_pr.min_hrs \
					from \
					wp_users usr, wp_erp_company_locations loc, wp_erp_hr_depts dept, wp_shop_employee_payrate emp_pr \
					where usr.id = emp_pr.employee_id \
					and loc.id= emp_pr.branch_id \
					and dept.id=emp_pr.depart_id";
				
				$.ajax({
					type:'POST',
					data: {'query':querysql},
					url : phpUrl+"getData.php", // read wp_shop_bonus table  
					dataType : "json"
				})
				.done(function (data) {
					
					var i = data.length;
					
					$(data).each(function () {
						var r = data[--i]; //one entry//
						console.log("employ history : "+r);
						
						var row = {
							"id" : r.id,
							"employee_id" : r.employee_id,
							"display_name" : r.display_name,
							"branch_name" : r.branch_name,
							"department_name" : r.department_name,						
							"pay_rate" :  r.pay_rate,
							"pay_type" : r.pay_type,
							
							"ot_rate" : r.ot_rate,
							"min_hrs" : r.min_hrs,
							"effective_date" :  r.effective_date
						};						 
						pay_rec.push(row); 
						
					});
					pay_rec.sort(function(a,b){
						var aId = a.employee_id ; 
						var bId = b.employee_id; 						
						return ((aId < bId) ? -1 : ((aId > bId) ? 1 : 0)); //顺序排序
									
					});
					d.resolve(pay_rec);					
				})
				.fail(function(data){
					console.log("jsGrid pay rate load fail.");
					console.log(data);
				});
				return d.promise();
			}
		},
		//db above ----------------------------

		fields : [
			/*{
				name : "id",
				title: "Entry ID",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : true,
				editing: false,
				width : "auto"
			},*/
			{
				name : "employee_id",
				title: "Employee ID",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : true,
				editing: false,
				width : "auto"
			},
			{
				name : "display_name", // 对应数组row中的index
				title : "Employee Name",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			},
			{
				name : "branch_name", // 对应数组row中的index
				title : "Branch",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			}, 			
			{
				name : "department_name",
				title : "Department",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},	
			{
				name : "effective_date",
				title : "Effective Date",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},
			{
				name : "pay_type",
				title : "Pay Type",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},
			{
				name : "pay_rate",
				title : "Pay Rate",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},				
			{
				name : "ot_rate",
				title : "OT Rate",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},	
			{
				name : "min_hrs",
				title : "Min Hour",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},
		
			{
				type : "control",
				editButton : false,
				deleteButton : true,//为了展示，先暂时关闭
				//deleteButton : false,//为了展示，先暂时关闭
				clearFilterButton : false,
				modeSwitchButton : false,

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
						$("#dialog-form-pay-rate").dialog().dialog("open");
						showDetailsDialog("Add", {});
					});
				}
			}
				

		]

	});	
	
	/**************************************************** Tab4 Settings Pay Rate end **********************************************************/
	
	
	/**************************************************** Tab4 Settings Product Sales Rate **********************************************************/
	$("#jsGrid_prd_sale_rate").jsGrid({
		height : "auto",
		width : "100%",

		//filtering: true,
		sorting : true,
		//editing: true,
		//inserting: true,
		/**/
		autoload : true,
		pagerContainer : "#externalPager_prd_sale_rate",
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
			 
			var msg="The entry:\n\n " +"#"+ item.entry_id + ","+ item.product_name +","+ item.product_sale_rate + ", .... \n\n will be DELETED. \n Are you sure?";
			var deleteFlag=0;
			
			var answer=confirm(msg);
			if (answer==true)
			{
				//php delete a row in table in db
				var tb="wp_shop_product_rate";
				$.ajax({
					type: "POST",
					url: phpUrl+"deleteData.php",  
					data: {
						id: item.entry_id,
						table: tb 
					}
				 
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
	 
		//db below here----------------------------
		controller : {
			loadData : function () {
				var d = $.Deferred();			 
           
				var prd_rec = [];
				var querysql="select \
					rt.id,  rt.effective_date, rt.sales_rate, \
					prd.product_name \
					from \
					wp_shop_products prd,  wp_shop_product_rate rt \
					where \
					prd.product_id=rt.product_id";
				$.ajax({
					type:'POST',
					data: {'query':querysql},
					url : phpUrl+"getData.php", // read wp_shop_bonus table  
					dataType : "json"
				})
				.done(function (data) {
					
					var i = data.length;
					
					$(data).each(function () {
						var r = data[--i]; //one entry//
						console.log("r: "+r);
						
						var row = {
							"prd_effective_date" : r.effective_date,
							"entry_id" : r.id,	// 			 
							"product_name" : r.product_name,
							"product_sale_rate" : r.sales_rate				 
					 
						};
						 
						prd_rec.push(row); 
					});
					prd_rec.sort(function(a,b){
						var aId = a.prd_id ; 
						var bId = b.prd_id; 						
						return ((aId < bId) ? -1 : ((aId > bId) ? 1 : 0)); //顺序排序
									
					});
					d.resolve(prd_rec);					
				})
				.fail(function(data){
					console.log("jsGrid bonus table load data fail.");
					console.log(data);
				});
				return d.promise();
			}
		},
		//db above ----------------------------

		fields : [
			/*{
				name : "entry_id",
				title: "Entry ID",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : true,
				editing: false,
				width : "auto"
			},*/
			{
				name : "product_name", // 对应数组row中的index
				title : "Product Name",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			},
			{
				name : "prd_effective_date", // 对应数组row中的index
				title : "Effective Date",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			}, 			
			{
				name : "product_sale_rate",
				title : "Sales Rate",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},			 
		
			{
				type : "control",
				editButton : false,
				deleteButton : true,//为了展示，先暂时关闭
				//deleteButton : false,//为了展示，先暂时关闭
				clearFilterButton : false,
				modeSwitchButton : false,

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
						$("#dialog-form-product-sale").dialog().dialog("open");
						showDetailsDialog("Add", {});
					});
				}
			}
				

		]

	});	
	
	/**************************************************** Tab4 Settings Product Sales Rate end **********************************************************/
	
	
	/**************************************************** Tab4 Settings Bonus **********************************************************/
	
	$("#jsGrid_bonus_threshold").jsGrid({
		height : "auto",
		width : "100%",

		//filtering: true,
		sorting : true,
		//editing: true,
		//inserting: true,
		/**/
		autoload : true,
		pagerContainer : "#externalPager_bonus_threshold",
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
			 
			var msg="The entry:\n\n " + item.id + ","+ item.employee_id +","+ item.branch_id + ", .... \n\n will be DELETED. \n Are you sure?";
			var deleteFlag=0;
			
			var answer=confirm(msg);
			if (answer==true)
			{
				//php delete a row in table in db
				var tb="wp_shop_bonus";
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
		/*
		onItemInserted : function (args) {
			//$("#jsGrid").jsGrid("refresh");

			$("#jsGrid").jsGrid("reset");
			//alert("refrsh!");
		},*/
		 
		

		//db below here----------------------------
		controller : {
			loadData : function () {
				var d = $.Deferred();
				var querysql="select \
					usr.display_name, \
					usr.id usrid, \
					loc.name, \
					dep.title, \
					bns.id, bns.effective_date, bns.bonus_threshold, bns.bonus_threshold_rate \
					from \
					wp_erp_hr_depts dep, wp_users usr, wp_shop_bonus bns, wp_erp_company_locations loc \
					where \
					bns.branch_id=loc.id  and \
					dep.id = bns.depart_id  and \
					bns.employee_id=usr.id ";
				$.ajax({
					type:'POST',
					data: {'query':querysql},
					url : phpUrl+"getData.php", // read wp_shop_bonus table  
					dataType : "json"
				})
				.done(function (data) {
					
					var i = data.length;
				 
					$(data).each(function () {
						var r = data[--i]; //one entry//
						console.log("r: "+r);
						
						var row = {
							"effective_date" : r.effective_date,												
							"employee_id": r.display_name,
							"branch_id" : r.name,						 
							"depart_id" : r.title,							 
							"bonus_threshold" : r.bonus_threshold,
							"bonus_threshold_rate" : r.bonus_threshold_rate,					 
							"id" : r.id,
							"usrid": r.usrid
						};
						 
						bonus_rec.push(row); //存放bonus threshold , threshold rate 
					});
					bonus_rec.sort(function(a,b){
						var aId = a.id ;
						var bId = b.id; 						
						return ((aId < bId) ? 1 : ((aId > bId) ? -1 : 0)); //逆序排序
									
					});
					d.resolve(bonus_rec);					
				})
				.fail(function(data){
					console.log("jsGrid bonus table load data fail.");
					console.log(data);
				});
				return d.promise();
			}
		},
		//db above ----------------------------

		fields : [
			/*{
				name : "id",
				title: "Entry ID",
				type : "text",
				align : "center",
				autosearch : true,
				sorting : true,
				editing: false,
				width : "auto"
			},*/
			{
				name : "employee_id", // 对应数组row中的index
				title : "Employee Name",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			},
			{
				name : "usrid", // 对应数组row中的index
				title : "Employee ID",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			}, 			
			{
				name : "branch_id",
				title : "Branch",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
			},
			{
				name : "depart_id", //name对应数据库中字段
				title: "Department",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
			}, 
			{
				name : "effective_date",
				title : "Effective Date",
				type : "text",
				align : "center",
				filtering : false,
				sorting : true,
				width : "auto"
				
			},
			{
				name : "bonus_threshold",
				title: "Turnover Threshold",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
			},			
			{
				name : "bonus_threshold_rate",
				title: "Threshold Rate",
				type : "text",
				align : "center",
				autosearch : true,
				width : "auto"
			}, 
		
			{
				type : "control",
				editButton : false,
				deleteButton : true,//为了展示，先暂时关闭
				//deleteButton : false,//为了展示，先暂时关闭
				clearFilterButton : false,
				modeSwitchButton : false,

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
						$("#dialog-form-bonus-threshold").dialog().dialog("open");
						showDetailsDialog("Add", {});
					});
				}
			}
				

		]

	});	
	/****************************************************Tab4 Settings Bonus **********************************************************/
 
});
																																			