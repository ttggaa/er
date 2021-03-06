<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <link rel="stylesheet" type="text/css" href="/Public/Css/easyui.css">
<link rel="stylesheet" type="text/css" href="/Public/Css/icon.css">
<link rel="stylesheet" type="text/css" href="/Public/Css/table.css">
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/Public/Js/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/Public/Js/datagrid.extends.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.extends.js"></script>
<script type="text/javascript" src="/Public/Js/tabs.util.js"></script>
<script type="text/javascript" src="/Public/Js/erp.util.js"></script>
<script type="text/javascript" src="/Public/Js/rich-datagrid.util.js"></script>
<script type="text/javascript" src="/Public/Js/thin-datagrid.util.js"></script>
<script type="text/javascript" src="/Public/Js/datalist.util.js"></script>
<script type="text/javascript" src="/Public/Js/area.js"></script>
-->
</head>
<body>
<!-- layout-datagrid -->
<div class="easyui-layout" data-options="fit:true" style="width:100%;height:100%;overflow:hidden;" id="panel_layout">
<!-- layout-center-datagrid -->
 
<div data-options="region:'center'" style="width:100%;background:#eee;"><table id="<?php echo ($datagrid["id"]); ?>" class="easyui-datagrid" data-options='<?php $dataOptions = array_merge(array ( 'border' => false, 'fit' => true, 'fitColumns' => true, 'rownumbers' => true, 'singleSelect' => true, 'pagination' => true, 'pageList' => array ( 0 => 20, 1 => 50, 2 => 100, ), 'pageSize' => 20, ), $datagrid["options"]);if(isset($dataOptions['toolbar']) && substr($dataOptions['toolbar'],0,1) != '#'): unset($dataOptions['toolbar']); endif;if(isset($dataOptions['methods'])): unset($dataOptions['methods']);endif; echo trim(json_encode($dataOptions), '{}[]').((isset($datagrid["options"]['toolbar']) && substr($datagrid["options"]['toolbar'],0,1) != '#')?',"toolbar":'.$datagrid["options"]['toolbar']:null).(isset($datagrid["options"]['methods'])? ','.$datagrid["options"]['methods']:null); ?>' style="<?php echo ($datagrid["style"]); ?>" ><thead><tr><?php if(is_array($datagrid["fields"])):foreach ($datagrid["fields"] as $key=>$arr):if(isset($arr['formatter'])):unset($arr['formatter']);endif;if(isset($arr['methods'])):unset($arr['methods']);endif;if(isset($arr['editor'])):unset($arr['editor']);endif;echo "<th data-options='".trim(json_encode($arr), '{}[]').(isset($datagrid["fields"][$key]['formatter'])?",\"formatter\":".$datagrid["fields"][$key]['formatter']:null).(isset($datagrid["fields"][$key]['editor'])?",\"editor\":".$datagrid["fields"][$key]['editor']:null).(isset($datagrid["fields"][$key]['methods'])?",".$datagrid["fields"][$key]['methods']:null)."'>".$key."</th>";endforeach;endif; ?></tr></thead></table></div> 
<!-- layout-south-tabs -->


</div>
<!-- dialog -->

	<div id="<?php echo ($id_list["setPrinter"]); ?>"></div>
	<div id="<?php echo ($id_list["print_dialog"]); ?>"></div>

<!-- toolbar -->

<div id="<?php echo ($id_list["tool_bar"]); ?>" style="padding:5px;height:auto">
<form id="<?php echo ($id_list["form"]); ?>" class="easyui-form" method="post">
<div class="search-condition form-div">
<label class="five-character-width">订单编号：</label><input class="easyui-textbox txt" type="text" name="trade_no" />
<label >店铺：</label><input class="easyui-textbox txt" type="text" name="shop_name" />
<a href = "javascript:void(0)" class="easy-linkbutton" name = "examine_num" data-options="plain:true" style = "float:right;margin-right:200px;color:red;font-size:10px;" onClick="stockoutExamine.open_print('单据打印','index.php/Stock/StockSalesPrint/getPrintList?stockout_no=examine_num')">未验货订单数量:<strong name="print_examine_num"><?php echo ($examine_num); ?></strong></a>
</div>
<hr style="margin-top: 2px;border:none;border-top:2px dotted #95B8E7;">
<div class="search-condition form-div">
<label class="five-character-width">类型：</label><input class="easyui-combobox txt" name="scan_class" data-options="valueField:'id',textField:'name',data:formatter.get_data('scan_class')"/>
<label >扫描：</label><input class="easyui-textbox txt" type="text" name="barcode_or_trade_no" />
<a href="javascript:void(0)" class="easyui-linkbutton" name = 'consign_examine' data-options="iconCls:'icon-ok'" onclick="stockoutExamine.consignCheck(1)">确认验货</a>
<a href="javascript:void(0)" class="easyui-linkbutton"  data-options="iconCls:'icon-setting'" onclick="stockoutExamine.setExamineConf()">验货配置</a>
<div style='display:inline-block;text-align:center;'><label>订单货品数量：</label><strong name='order_goods_num' style="vertical-align:middle">0</strong><label>,已扫描货品数量：</label><strong name='scan_goods_num' style="vertical-align:middle">0</strong></div>
<div style='display:inline-block;text-align:center;'><strong name='message_info' style="vertical-align:middle;font-size:20px;color:red;margin-left:20px"></strong></div>
<div style='display:inline-block;float: right;margin-right: 10px;'>
	<!--<a href="javascript:void(0)" style="font-size: 20px;" name="select_printer" class="easyui-linkbutton" data-options="iconCls:''" onclick="stockoutExamine.setPrintersDialog()";>选择打印机</a>-->

	<select id="stock_out_examine_config" style="width:162px;"></select>
	<div id="stock_out_examine_config_value">
		<div style="padding:10px">
			<input type="checkbox" name="pic_preview" value="1"><span>开启图片预览</span><br/>
			<input type="checkbox" name="sound_prompt" value="1"><span>开启声音提示</span><br/>
			<input type="checkbox" name="quick_examine" value="1"><span>开启快速验货</span><br/>
			<input type="checkbox" name="examine_print_logistics" value="1"><span>验货后立即打印物流单</span><br/>
		</div>
		<div style="margin-left: 4px;margin-top: 70px;background:#fafafa;width:150px;border:1px solid #ccc">
			<a href="javascript:void(0)" style="margin-left: 50px" class="easyui-linkbutton" name = 'print_config' onclick="stockoutExamine.printConfig()">打印设置</a>
		</div>
	</div>
</div>
</div>

<hr style="margin-top: 2px;border:none;border-top:2px dotted #95B8E7;">
<input type="hidden"  name='stockout_id' value="0">
<input type="hidden"  name='stockout_no' value="">
</form>
<div class="search-condition form-div">
<label>订单货品列表</label>
<audio id="success_sound">
	<source src="/Public/Image/success.mp3" >
</audio>
<audio id="warn_sound">
	<source src="/Public/Image/warn.mp3" >
</audio>
</div>
</div><div id="examineSetLogisticsPrintersDialog"></div>

<script>
//# sourceURL=stockoutexamine.js
var stockoutexamineWs;
	(function(){
	var global_trade_no = null;
	var global_is_play_sound = 1;
	var global_is_quick_examine = 0;
	var global_is_print_logistics = 0;
	function StockoutExamine(params,form_selector_list){
		this.params = params;
		var init_form = {
				"trade_no"	: "", "shop_name"		: "", "scan_class"		: "trade_no", "barcode_or_trade_no"		: "<?php echo ($src_order_no); ?>",'order_goods_num':'0','scan_goods_num':'0','stockout_id':'0','stockout_no':'0','message_info':'',"print_examine_num":"<?php echo ($examine_num); ?>"
		};
		this.input_type_list = {
				'trade_no':'textbox','shop_name':'textbox', 'scan_class':'combobox', 'barcode_or_trade_no'	:'textbox','order_goods_num':'html','scan_goods_num':'html','consign_examine':'linkbutton','stockout_id':'input','stockout_no':'input','message_info':'html','print_examine_num':'html'
		};
		this.disabled_input_list ={
				'trade_no':1,'shop_name':1, 'scan_class':0, 'barcode_or_trade_no':0,'consign_examine':0
		};
		this.enable_input_list ={
				'trade_no':0,'shop_name':0, 'scan_class':1, 'barcode_or_trade_no':1,'consign_examine':1
		};
		this.is_manual_scan = 0;//初始手工验货状态为：非手工状态0
		this.form_selector_list = form_selector_list;
		this.init_form_data =$.extend({},init_form);
		this.scan_status = 0;//1表示已扫描订单，0标示未扫描订单
		this.scan_goods_num = 0;//初始化扫描货品的数量为0
	}
	StockoutExamine.prototype = {
		open_print:function(title,url,value){
			var param = {};
			if(value!=undefined){
				param['stockout_no'] = value;
			}else{
				param['stockout_no'] = 'examine_num';
			}
			open_menu(title, url);
			switch(title){
			case '单据打印' :
				if($('#container').tabs('exists',title)){
					$.get("<?php echo U('Stock/StockSalesPrint/search');?>",param,function(res){
							$('#stocksalesprint_datagrid').datagrid('loadData',res);
					});
				}
				break;
			}
		},
		initShow:function(){
			var that = this;
			this.scan_status = 0;//标识订单是否扫描过了
			var init_data = this.init_form_data;
			this.initFormData(0);
			this.form_selector_list.barcode_or_trade_no.textbox('textbox').bind('keydown',function(e){if(e.keyCode==13){that.submitNo(e);}});
			this.diableFormList();
			this.tempClickCell = undefined;
			//--------datagrid初始操作
			$('#'+that.params.datagrid.id).datagrid('options').rowStyler = this.flagRowStatusByRowStyle;
			$('#'+that.params.datagrid.id).datagrid('options').onEndEdit = this.beforeEndEditRow;
			$('#'+that.params.datagrid.id).datagrid('options').onClickCell = this.onClickCell;
			$('#'+that.params.datagrid.id).datagrid('options').erpTabObject = this;
			if(that.params.get_config.pic_preview == 1){
				StockoutExamine.form_selector_list.pic_preview.prop('checked',true);
			}else{
				StockoutExamine.form_selector_list.pic_preview.prop('checked',false);
			}
			if(that.params.get_config.prompt_sound == 1){
				StockoutExamine.form_selector_list.sound_prompt.prop('checked',true);
			}else{
				global_is_play_sound = 0;
				StockoutExamine.form_selector_list.sound_prompt.prop('checked',false);
			}
			if(that.params.get_config.quick_examine == 1){
				global_is_quick_examine = 1;
				StockoutExamine.form_selector_list.quick_examine.prop('checked',true);
			}else{
				StockoutExamine.form_selector_list.quick_examine.prop('checked',false);
			}
			if(that.params.get_config.examine_print_logistics == 1){
				global_is_print_logistics = 1;
//				StockoutExamine.form_selector_list.select_printer.linkbutton({disabled:false});
				StockoutExamine.form_selector_list.examine_print_logistics.prop('checked',true);
			}else{
//				StockoutExamine.form_selector_list.select_printer.linkbutton({disabled:true});
				StockoutExamine.form_selector_list.examine_print_logistics.prop('checked',false);
			}
		},
		initFormData:function(type,update_data_obj){
			var that = this;
			var init_data = {};//this.init_form_data;
			this.is_manual_scan = 0;//初始手工验货状态为：非手工状态0
			if(type == 0){
				init_data = $.extend({},that.init_form_data);
			}else if(type == 1 && update_data_obj != undefined && $.isPlainObject(update_data_obj)){
				init_data = $.extend({},that.init_form_data,update_data_obj);
				console.log(that.init_form_data);
				console.log(update_data_obj);
				console.log(init_data);
			}else if(type == 3){
				this.form_selector_list['scan_class'].combobox('setValue','trade_no');
				this.form_selector_list.barcode_or_trade_no.textbox('setValue','');
				this.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
				this.scan_status = 0;//标识订单是否扫描过了
				return;
			}
			for(var item_name in init_data){
				if(that.init_form_data[item_name] != undefined){
					var component_type = this.input_type_list[item_name];
					var component_value = init_data[item_name];
					if(component_type == 'html'){
						this.form_selector_list[item_name].html(component_value);
					}else if(component_type == 'input'){
						this.form_selector_list[item_name].val(component_value);
					}else{
						this.form_selector_list[item_name][component_type]('setValue',component_value);
					}
				}
			}
			if(type == 0){
				this.form_selector_list['scan_class'].combobox('setValue','trade_no');
				//this.form_selector_list.barcode_or_trade_no.textbox('setValue','');
				this.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
				this.scan_status = 0;//标识订单是否扫描过了
			}else if(type == 1 ){
				this.form_selector_list['scan_class'].combobox('setValue','barcode');
				this.form_selector_list.barcode_or_trade_no.textbox('setValue','');
				this.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
				this.scan_status = 1;//标识订单是否扫描过了
			}
		},
		//--------0：验货数量< 单据实际数量 1：验货数量==单据实际数量  2：验货数量 > 单据中的实际数量
		flagRowStatusByRowStyle:function(index,row){
			 if(parseInt(row.num_status)==2){
				return 'background-color:#ff0000';
			}else if(parseInt(row.num_status) ==1){
				return 'background-color:#008000';
			}
		},
		//---------行编辑完成之后，还没有销毁编辑器的时候触发
		beforeEndEditRow:function(index,row,changes){
			var clickCell_name=	$(this).datagrid('options').erpTabObject.clickCell_name;
			if(clickCell_name!='check_num'){
				return;
			}
			row.scan_type=2;
			if(parseFloat(row.check_num)>parseFloat(row.num)){
				row.num_status = 2;
				stockoutExamine.playWarnSound();
				messager.alert('校验数量大于货品实际数量！');
			}else if(parseFloat(row.check_num)==parseFloat(row.num)){
				row.num_status = 1;
				stockoutExamine.playSuccessSound();
			}else {
				row.num_status = 0;
			}
			var datagrid_id =$(this).datagrid('options').erpTabObject.params.datagrid.id;
			var rows = $('#'+datagrid_id).datagrid('getRows');
			var scan_goods_num=0;
			for(var i in rows){
			 scan_goods_num +=parseFloat(rows[i]['check_num']);
			}
			$(this).datagrid('options').erpTabObject.form_selector_list['scan_goods_num'].html(scan_goods_num);
			var erpTabObject = $(this).datagrid('options').erpTabObject;
			/* if(erpTabObject.judgeSuccessAboutCheck()){
				erpTabObject.consignCheck();
			} */
		},
		judgeSuccessAboutCheck:function(){
			var that = this;
			var datagrid_id = that.params.datagrid.id;
			var all_rows = $('#'+datagrid_id).datagrid('getRows');
			var scan_status = 1;//完成
			for(var i in all_rows){
				var row_num = parseInt(all_rows[i]['num']);
				var row_check_num = parseInt(all_rows[i]['check_num']);
				if(row_num != row_check_num){
					scan_status = 0;//未完成
					return false;
				}
			}
			return true;
		},
		stopDefault : function(e){  //防止冒泡
			if(e.preventDefault) {
				//阻止默认浏览器动作(W3C)
				e.preventDefault();
			}else{
				//IE中阻止函数器默认动作的方式
				window.event.returnValue = false;
			}
			return false;
		},
		onClickCell:function(index,field,value){
			$(this).datagrid('options').erpTabObject.clickCell_name=field;
			if(field=='check_num'){
				$(this).datagrid('options').erpTabObject.is_manual_scan = 1;
			}
		},
		diableFormList :function(){
			var disable_list = this.disabled_input_list;
			for(var item_name in  disable_list){
				if(disable_list[item_name]==1){
					var component_type = this.input_type_list[item_name];
					this.form_selector_list[item_name][component_type]('disable');
				}
			}
		},
		enableFormList :function(){
			var enable_list = this.enable_input_list;
			for(var item_name in  enable_list){
				if(enable_list[item_name]==1){
					var component_type = this.input_type_list[item_name];
					this.form_selector_list[item_name][component_type]('enable');
				}
			}
		},
		getStockoutOrderInfo:function(trade_no){
			var that = this;
			$.post('<?php echo U("Stock/SalesStockoutExamine/getStockoutOrderDetail");?>',{trade_no:trade_no},function(result){
				//成功
				if(result.status == 0){
					global_trade_no = trade_no;
					var datagrid_id = that.params.datagrid.id;
					that.suite_no = result.suite_no;
					if(global_is_quick_examine){
						//var resule_detail_rows = result.stockout_order_detial_goods_info.rows;
						for(var i=0; i<result.stockout_order_detial_goods_info.rows.length; ++i){
							result.stockout_order_detial_goods_info.rows[i]['check_num'] = result.stockout_order_detial_goods_info.rows[i]['num'];
							result.stockout_order_detial_goods_info.rows[i]['num_status'] = 1;
						}
						var init_data = {};
						init_data = $.extend({},that.init_form_data,result.stockout_order_info);
						for(var item_name in init_data){
							if(that.init_form_data[item_name] != undefined){
								var component_type = that.input_type_list[item_name];
								var component_value = init_data[item_name];
								if(component_type == 'html'){
									that.form_selector_list[item_name].html(component_value);
								}else if(component_type == 'input'){
									that.form_selector_list[item_name].val(component_value);
								}else{
									that.form_selector_list[item_name][component_type]('setValue',component_value);
								}
							}
						}
						//var datagrid_id =$(that).datagrid('options').erpTabObject.params.datagrid.id;
						var rows = $('#'+datagrid_id).datagrid('getRows');
						var scan_goods_num=result.stockout_order_info.order_goods_num;
						that.form_selector_list['order_goods_num'].html(scan_goods_num);
						that.form_selector_list['scan_goods_num'].html(scan_goods_num);
						$('#'+datagrid_id).datagrid('loadData',result.stockout_order_detial_goods_info);

						//that.form_selector_list['scan_class'].combobox('setValue','barcode');
						that.form_selector_list.barcode_or_trade_no.textbox('setValue','');
						that.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
						that.scan_status = 1;//标识订单是否扫描过了
						stockoutExamine.consignCheck(1);
						stockoutExamine.playSuccessSound();
					}else{
						$('#'+datagrid_id).datagrid('loadData',result.stockout_order_detial_goods_info);
						that.initFormData(1,result.stockout_order_info);
						var datagrid_data = $('#'+datagrid_id).datagrid('getRows');
						var scan_goods_num = 0;
						for(var row_index in datagrid_data){
							var now_row = datagrid_data[row_index];
							var now_index = $('#'+that.params.datagrid.id).datagrid('getRowIndex',now_row);
							if(now_row['is_not_need_examine']==1){
								now_row['scan_type'] = parseInt(now_row['scan_type']) == 2?2:1;
								now_row['num_status'] = 1;
								now_row['check_num'] = parseInt(now_row['num']);
								$('#'+that.params.datagrid.id).datagrid('updateRow',{index:now_index,row:now_row});
							}
							scan_goods_num = scan_goods_num+parseInt(now_row['check_num']);
						}
						that.form_selector_list['scan_goods_num'].html(scan_goods_num);
					}
				}else if(result.status == 1){
					that.playWarnSound();
					messager.alert(result.info,undefined,function(){
						that.form_selector_list['scan_class'].combobox('setValue','trade_no');
						that.form_selector_list.barcode_or_trade_no.textbox('setValue','');
						that.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
					});

				}else if(result.status == 2){
					that.playWarnSound();
					if(result.solve_way == "拦截出库"){
						var block_reason = parseInt(result.stock['block_reason']);
						var number = $.inArray(block_reason,[1,2,4,32,128,256])
						if(number >= 0) {
							result.solve_way= '<a href="javascript:void(0)" onClick="stockoutExamine.jump(\'单据打印\', \'<?php echo U('Stock/StockSalesPrint/getPrintList');?>?stockout_no='+result.stock['stockout_no']+'\',\''+result.stock['stockout_no']+'\')">单据打印页面【驳回到订单审核重新审核】</a>';
						}else{
						   result.solve_way= '<a href="javascript:void(0)" onClick="stockoutExamine.jump(\'单据打印\', \'<?php echo U('Stock/StockSalesPrint/getPrintList');?>?stockout_no='+result.stock['stockout_no']+'\',\''+result.stock['stockout_no']+'\')">单据打印页面【驳回到订单审核重新审核或取消拦截】</a>';

						}
					}else if(result.msg == '订单已发货'){
						  result.solve_way= '<a href="javascript:void(0)" onClick="stockoutExamine.jump(\'单据打印\', \'<?php echo U('Stock/StockSalesPrint/getPrintList');?>?stockout_no='+result.stock['stockout_no']+'\',\''+result.stock['stockout_no']+'\')">单据打印页面【撤销出库】</a>';
					}
					result.stock_no = result.stock['stockout_no'];
					var info = [];
					info.push(result);
					$.fn.richDialog("response", info, "stockout");
				}
			},'json');
		},
		jump:function(title,url,stock_no){
			$('#response_dialog').dialog('close');
			if($("#container").tabs('exists', title)){
				open_menu(title, url);
				switch(title){
					case '单据打印' :
						if($('#container').tabs('exists',title)){
					$.post("<?php echo U('Stock/StockSalesPrint/search');?>",{'search[stockout_no]':stock_no},function(res){
						$('#'+stockSalesPrint.params.datagrid.id).datagrid('loadData',res);
					});
				}
				break;
			}
			}else{
				open_menu(title, url);
			}
		},
		getScanGoodsInfo:function(no_value,scan_type,trade_no){
			var that = this;
			$.post('<?php echo U("Stock/SalesStockoutExamine/examineGoodsByBarcode");?>',{barcode:no_value,scanType:scan_type,tradeNo:trade_no},function(result){
				//成功
				if(result.status == 0){
					var goods_list = result.match_goods_list.rows;
					StockoutExamine.goods_list = result.match_goods_list.rows;//为了使对话框获取相关货品数据，保存到StockoutExamine的私有属性里面
					if($.isEmptyObject(goods_list)){
						that.form_selector_list['message_info'].html('输入码：'+no_value+' 不存在');
						that.playWarnSound();
					}else if(goods_list.length == 1){
						that.updateScanGoodsNum(goods_list[0]);
					}else if(goods_list.length > 1){
						//主页的默认的对话框
						$('#flag_set_dialog').dialog({
							title:that.params.select.title,
							iconCls:'icon-save',
							width:that.params.select.width==undefined?764:that.params.select.width,
							height:that.params.select.height==undefined?560:that.params.select.height,
							closed:false,
							inline:true,
							modal:true,
							href:that.params.select.url+'?parent_datagrid_id='+that.params.datagrid.id+'&parent_object=StockoutExamine&goods_list_dialog=flag_set_dialog',
							buttons:[]
						});
					}else{
						that.playWarnSound();
						messager.alert('未获取到任何数据请联系管理员');
					}

				}else if(result.status == 1){
					that.playWarnSound();
					that.form_selector_list['message_info'].html(result.msg);
				}
			},'json');
	//		that.form_selector_list['scan_class'].combobox('setValue','barcode');
			that.form_selector_list.barcode_or_trade_no.textbox('setValue','');
			that.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
		},
		updateScanGoodsNum:function(scan_goods){
			var that = this;
			var datagrid_data = $('#'+that.params.datagrid.id).datagrid('getRows');
			var suite_no = that.suite_no;
			var scan_goods_num = 0;
			var is_match = 0;
			var in_suite = 0;
			if(scan_goods['is_suite'] == '1'){
				for(var k in suite_no){
					if(suite_no[k]['suite_no'] == scan_goods['spec_no']){
						in_suite = 1;
						break;
					}
				}
				if(in_suite == 1){
					$.post("<?php echo U('Stock/SalesStockoutExamine/getSuiteInfo');?>",{no:scan_goods['spec_no']},function(r){
						if(r.status == 0){
							var info = r.info;
							for(var datagrid_index in datagrid_data){
								var now_row = datagrid_data[datagrid_index];
								var now_index = $('#'+that.params.datagrid.id).datagrid('getRowIndex',now_row);
								for(var suite_index in info ){
									if(now_row['spec_no'] == info[suite_index]['spec_no']){
										now_row['scan_type'] = parseInt(now_row['scan_type']) == 2?2:1;
										if(parseInt(now_row['num'])- parseInt(now_row['check_num'])== parseInt(info[suite_index]['num'])){
											now_row['num_status'] = 1;
											that.playSuccessSound();
										}else if(parseInt(now_row['num'])- parseInt(now_row['check_num'])< parseInt(info[suite_index]['num'])){
											now_row['num_status'] = 2;
											that.playWarnSound();
											messager.alert('校验量超过货品实际数量!');
										}else{
											now_row['num_status'] = 0;
										}
										now_row['check_num'] = parseInt(now_row['check_num'])+parseInt(info[suite_index]['num']);
										$('#'+that.params.datagrid.id).datagrid('updateRow',{index:now_index,row:now_row});
									}
								}
								scan_goods_num = scan_goods_num+parseInt(now_row['check_num']);
							}
							that.form_selector_list['message_info'].html('');
						}else{
							messager.alert(r.info);
						}
						that.form_selector_list['scan_goods_num'].html(scan_goods_num);
						if(that.judgeSuccessAboutCheck()){
						that.consignCheck();
						}
					});
				}else{
					that.form_selector_list['scan_goods_num'].html(scan_goods_num);
					if(that.judgeSuccessAboutCheck()){
						that.consignCheck();
					}
					that.form_selector_list['message_info'].html('订单不包含该组合装');
					that.playWarnSound();
				}
			}else{
				for(var row_index in datagrid_data){

					var now_row = datagrid_data[row_index];
					var now_index = $('#'+that.params.datagrid.id).datagrid('getRowIndex',now_row);
					if(now_row['spec_no']==scan_goods['spec_no']){
						is_match = 1;
						now_row['scan_type'] = parseInt(now_row['scan_type']) == 2?2:1;
						if(parseInt(now_row['num'])- parseInt(now_row['check_num'])==1){
							now_row['num_status'] = 1;
							that.playSuccessSound();
						}else if(parseInt(now_row['num'])- parseInt(now_row['check_num'])<1){
							now_row['num_status'] = 2;
							that.playWarnSound();
							messager.alert('校验量超过货品实际数量!');
						}else{
							now_row['num_status'] = 0;
						}
						now_row['check_num'] = parseInt(now_row['check_num'])+ 1;
						$('#'+that.params.datagrid.id).datagrid('updateRow',{index:now_index,row:now_row});
					}
					scan_goods_num = scan_goods_num+parseInt(now_row['check_num']);

				}
				if(is_match == 0){
					that.playWarnSound();
					that.form_selector_list['message_info'].html('订单不包含该货品');
				}else{
					that.form_selector_list['message_info'].html('');
				}
				that.form_selector_list['scan_goods_num'].html(scan_goods_num);
				if(that.judgeSuccessAboutCheck()){
					that.consignCheck();
				}
			}
		},
		submitNo : function(e){
			var that = this;
			var scan_type = this.form_selector_list['scan_class'].combobox('getValue');
			var sl = this.form_selector_list.barcode_or_trade_no.textbox('textbox');
			var no_value  = $(sl).val();
			no_value =  $.trim(no_value);
			var scan_status = this.scan_status;
			if(e != undefined){
				this.stopDefault(e);
			}
			if(scan_type=='trade_no' && scan_status ==1){
				messager.confirm('当前验货还没有完成，需要替换新订单吗？',function(r){
					if(r){
						try{
							that.getStockoutOrderInfo(no_value);
						}catch(e){
							that.playWarnSound();
							messager.alert('异常请联系管理员！');
						}
					}else{
						that.form_selector_list['scan_class'].combobox('setValue','barcode');
						that.form_selector_list.barcode_or_trade_no.textbox('setValue','');
						that.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
					}
				});
			}else if(scan_type=='trade_no' && scan_status ==0){
				$('#'+that.params.datagrid.id).datagrid('options').onClickCell = that.tempClickCell == undefined?$('#'+that.params.datagrid.id).datagrid('options').onClickCell:that.tempClickCell;
				that.getStockoutOrderInfo(no_value);
			}else if(scan_type=='barcode' && scan_status ==1){
				that.getScanGoodsInfo(no_value,'barcode','');
			}else if(scan_type=='unique_code' && scan_status ==1){
				if(global_trade_no != null){
					that.getScanGoodsInfo(no_value,'uniquecode',global_trade_no);
				}
			}else {
				that.playWarnSound();
				messager.alert('请先扫描订单',undefined,function(){
					that.form_selector_list['scan_class'].combobox('setValue','trade_no');
					that.form_selector_list.barcode_or_trade_no.textbox('setValue','');
					that.form_selector_list.barcode_or_trade_no.textbox('textbox').focus();
				});
				return;
			}
		},
		setScanStatus:function(status){
			this.scan_status = status;
		},
		consignCheck : function(is_force){
			var that = this;
			var stockout_id = that.form_selector_list.stockout_id.val();
			if(that.scan_status == 0 || $.isEmptyObject(stockout_id) || !$.isNumeric(parseInt(stockout_id)) || parseInt(stockout_id)==0){
				that.playWarnSound();
				messager.alert('请先扫描订单');
				return;
			}
			if(!that.judgeSuccessAboutCheck()){
				that.playWarnSound();
				messager.alert('请确认出库数量正确');
				return;
			}
			if((is_force==undefined || is_force == false) && that.is_manual_scan == 1){
				that.playWarnSound();
				return;
			}
			var datagrid_id = that.params.datagrid.id;
			var check_rows = $('#'+datagrid_id).datagrid('getRows');

			check_rows = JSON.stringify(check_rows);
			$.post('<?php echo U("Stock/SalesStockoutExamine/consignCheck");?>',{stockout_id:stockout_id,check_goods_list:check_rows},function(result){
				if(result.status == 1){
					that.tempClickCell = $('#'+that.params.datagrid.id).datagrid('options').onClickCell;
					$('#'+that.params.datagrid.id).datagrid('options').onClickCell = function(){return;};
					that.initFormData(3);
					that.playWarnSound();
					that.form_selector_list.message_info.html(result.info);
				}else if(result.status == 0 || result.status == 2){
					that.tempClickCell = $('#'+that.params.datagrid.id).datagrid('options').onClickCell;
					$('#'+that.params.datagrid.id).datagrid('options').onClickCell = function(){return;};
					that.initFormData(3);
					that.form_selector_list.message_info.html(result.info);
					if(global_is_print_logistics){
						that.printLogisticsOrder();
					}
					$.post('<?php echo U("Stock/SalesStockoutExamine/getExamineNum");?>','',function(r){
						if(r.status == 1){
							messager.alert(r.info);
							return;
						}
						that.form_selector_list.print_examine_num.html(r.info);
					});
				}else{
					that.playWarnSound();
					messager.alert('请联系管理员');
				}

			},'json');
		},
		printConfig : function (){
            $("#examineSetLogisticsPrintersDialog").dialog({
                href:"<?php echo U('SalesStockoutExamine/setLogisticsAndTemplatesDialog');?>",
                width:540,
                height:300,
                inline: true,
                modal: true,
                title:"设置物流单打印机和模板",
                iconCls: 'icon-save',
                buttons:[{
                    text:'保存',
                    handler:function(){stockoutExamine.savePrintersAndTemplatesSetting();}
                }]
            });
        },
        savePrintersAndTemplatesSetting:function (){
            var that = this;
            var row = $('#'+examine_set_logistics_templates.params.datagrid.id).datagrid('getSelected');
            var row_index = $('#'+examine_set_logistics_templates.params.datagrid.id).datagrid('getRowIndex',row);
            $('#'+examine_set_logistics_templates.params.datagrid.id).datagrid('endEdit',row_index);
            var rows = $('#'+examine_set_logistics_templates.params.datagrid.id).datagrid('getRows');
            var is_submit = true;
            for(var i in rows){
                if((rows[i]['name'] != '无') && (rows[i]['title'] == '无'))
                    is_submit = false;
            }

            if(is_submit){
                $.post("<?php echo U('Stock/SalesStockoutExamine/submitPrintersAndTemplatesSet');?>", {printer_template_data:rows}, function(r){
                    messager.alert(r.info);
                    $('#examineSetLogisticsPrintersDialog').dialog('close');
                });
            }else{
                messager.alert('请将模板和打印机一起设置');
            }
        },
		connectStockWS : function(){
			if(stockoutexamineWs == undefined){
				stockoutexamineWs = new WebSocket("ws://127.0.0.1:13528");
				stockoutexamineWs.onmessage = function(event){stockoutExamine.onStockMessage(event);};//this.onStockMessage;
				stockoutexamineWs.onerror = function(){stockoutExamine.onStockError();};//this.onStockError;
			}
			return ;
		},
		onStockMessage : function(event){
			var response_result =JSON.parse(event.data);
			if(!$.isEmptyObject(response_result.status) && response_result.status != 'success'){
				messager.alert(response_result.msg);
				return;
			}
			if(!$.isEmptyObject(response_result))
			{
				switch(response_result.cmd){
					case 'getPrinters':/*打印机列表命令*/
					{
						var type = response_result.requestID;
						type = type.substr(type.length-2,type.length);
						if(type == 99){
							$('#examine_logistic_printer_list').combobox({
								valueField: 'name',
								textField: 'name',
								data: response_result.printers,
								value: response_result.defaultPrinter
							});
							$('#examine_logistic_printer_list').combobox('reload');
						}else {
                            $('#examine_printer_data').combobox({
                                valueField: 'name',
                                textField: 'name',
                                data: response_result.printers,
                                value: response_result.defaultPrinter
                            });
                            $('#examine_printer_data').combobox('reload');
						}
						break;
					}
					case 'print':
					{
						var taskID = response_result.taskID+"";
						taskID = taskID.substr(taskID.length-3,taskID.length);
						if(taskID==231)
						{
							var preview;
							preview = response_result.previewURL;
							if(!$.isEmptyObject(preview))
								window.open(response_result.previewURL);
							preview = response_result.previewImage;
							if(!$.isEmptyObject(preview)&&(preview.length != 0))
								window.open(response_result.previewImage[0]);
						}
						break;
					}
					case 'notifyPrintResult':
					{
						if(response_result.taskStatus == "printed"){
							var stockout_ids = stockoutExamine.form_selector_list.stockout_id.val();
							var parameters = {stockout_ids:stockout_ids,print_type:'logistics',is_print:1,multiIds:'',value:1};
							Post("/index.php/Stock/StockSalesPrint/changePrintStatus",parameters);
							var type = response_result.taskID;
							type = type.substr(type.length-2,type.length);
							if(type==22){
								stockoutExamine.form_selector_list.message_info.html("物流单打印完成");
								//messager.alert("物流单打印完成");
							}
							//$("#<?php echo ($id_list["print_dialog"]); ?>").dialog('close');
						}else if(response_result.taskStatus == "failed"){
							messager.confirm('打印失败,请到单据打印界面重新打印',function(r){
								if(r) stockoutExamine.open_print('单据打印','index.php/Stock/StockSalesPrint/getPrintList?stockout_no='+stockout_no,stockout_no);
							});
							//messager.alert("打印失败");
						}
						break;
					}
				}
			}
		},
		onStockError : function(){
			stockoutexamineWs = null;
			var print_dialog = '<?php echo ($id_list["print_dialog"]); ?>';
			$('#'+print_dialog).dialog({
				title: '打印组件错误',
				width: 400,
				height: 200,
				closed: false,
				cache: false,
				href:  "<?php echo U('Stock/StockSalesPrint/onWSError');?>",
				modal: true
			});
		},
		setPrintersDialog : function () {
			$("#<?php echo ($id_list["setPrinter"]); ?>").dialog({
				href:"<?php echo U('SalesStockoutExamine/getTemplates');?>",
				width:330,
				height:140,
				inline: true,
				modal: true,
				title:"选择打印机",
				iconCls: 'icon-save',
				buttons:[{
					text:'保存',
					handler:function(){stockoutExamine.savePrintSetting();}
				}]
			});
		},
		savePrintSetting:function (){
			if(getSysDefTemp() == '-1'){
				messager.alert('请先去下载"系统默认自定义区"模板');
				return;
			}
			var logistic_printer = $('#examine_logistic_printer_list').combobox('getValue');
			var logisticsObj = {
				'logistic_printer':logistic_printer,
			};
			var jsonStr = JSON.stringify(logisticsObj);
			$.post("/index.php/Stock/SalesStockoutExamine/savePrinters", {logisticsInfo:jsonStr}, function(r){
				$("#<?php echo ($id_list["setPrinter"]); ?>").dialog('close');
				if(r.status != 0){
					messager.alert(r.info);
				}
			});
		},
		selectPrinter:function(type){
			stockoutExamine.connectStockWS();
			type = type == "goods"?"99":"88";
			var request = {
				"cmd":"getPrinters",
				"requestID":"123458976"+type,
				"version":"1.0"
			};
			stockoutexamineWs.send(JSON.stringify(request));
		},
		printLogisticsOrder : function(){
			var that = this;
			var data,printerInfo,sortInfo,goods_info,baseSet,customTempUrl,row,detail;
			var stockout_id = this.form_selector_list.stockout_id.val();
			var stockout_no = this.form_selector_list.stockout_no.val();
			$.post("<?php echo U('Stock/SalesStockoutExamine/getExaminePrintData');?>",{stockout_id:stockout_id},function(r){
				switch(r.status){
					case 0 :
						data = r.data.waybill_print_info;
						printerInfo = r.data;
						customTempUrl = r.data.custom_template_url;
						row = r.data.row;
						detail = r.data.goods;
						if(printerInfo.logistic_printer == ''){
							messager.alert('请先选择打印机');
							return;
						}
						if(data != -1)
						{
							var datas = that.getLogisticsOrderData(data,customTempUrl,row,detail,data.waybill_info.waybillCode);
							if(datas === false){
								return;
							}
							that.newPrint(datas,printerInfo.logistic_printer,22);
						}
						break;
					case 1 :
						if(r.msg=='该店铺未授权或授权已失效'){messager.alert('打印失败,'+r.msg);}
						else{
							//messager.alert('打印失败,获取电子面单失败,请到'+'<a href = "javascript:void(0)" onClick="stockoutExamine.open_print(\'单据打印\',\'index.php/Stock/StockSalesPrint/getPrintList?stockout_no='+stockout_no+'\',\''+stockout_no+'\')">单据打印</a>'+'界面重新打印');
							messager.confirm('打印失败,获取电子面单或者模板失败,请到单据打印界面重新打印',function(r){
								if(r) stockoutExamine.open_print('单据打印','index.php/Stock/StockSalesPrint/getPrintList?stockout_no='+stockout_no,stockout_no);
							});
						}
						break;
					case 2 :
						if(r.msg=='只支持打印菜鸟电子面单，请前往“单据打印”界面打印非电子面单'){
							messager.confirm('只支持打印菜鸟电子面单，请前往单据打印界面打印非电子面单',function(r){
								if(r) stockoutExamine.open_print('单据打印','index.php/Stock/StockSalesPrint/getPrintList?stockout_no='+stockout_no,stockout_no);
							});
						}
						else{messager.alert(r.msg);}
						break;
				}
			});
		},
		newPrint : function(datas,printer,taskID){
			stockoutExamine.connectStockWS();
			var requestID =  (new Date()).valueOf();
			var request = {
				'cmd' : 'print',
				'version' : '1.0',
				'requestID' : requestID,
				'task' : {
					'taskID' : requestID +''+taskID,
					'printer' : printer,//'',
					'preview' : false,
					'notifyMode':'allInOne',
					'documents' : datas
				}
			};
			stockoutexamineWs.send(JSON.stringify(request));
		},
		getLogisticsOrderData : function(data,templateUrl,row,detail,logistics_no){
			var customArea_data = data;
			customArea_data.trade = {
				'trade_no' : row.src_order_no,//订单标号
				'src_tids' : row.src_tids,//原始单号
				'logistics_no' : logistics_no,
				'package_code' : logistics_no+"-1-1-",
				'package_id' : row.id,
				'goods_amount' : row.goods_total_cost,
				'cargo_total_weight' : row.weight,
				'calc_weight' : row.calc_weight,
				'receivable' : row.receivable,
				'goods_count' : row.goods_count,
				'goods_type_count' : row.goods_type_count,
				'print_date' : (new Date()).getFullYear()+"-"+((new Date()).getMonth()+1)+"-"+(new Date()).getDate(),//(new Date()).toLocaleString().replace(/\//g,"-").substring(0,9),
				'cs_remark' : row.cs_remark,
				'print_remark' : row.print_remark,
				'buyer_nick' : row.buyer_nick,
				'buyer_message' : row.buyer_message,
				'invoice_content' : row.invoice_content,
				'cod_amount' : row.cod_amount,
				'receiver_dtb' : row.receiver_dtb,
				'invoice_title' : row.invoice_title,
				'trade_time' : row.pay_time,
				'post_amount' : row.post_amount
			};
			customArea_data.shop = {
				'name' : row.shop_name,
				'website' : row.website
			};
			customArea_data.recipient = {
				'name' : row.receiver_name,
				'mobile': !(row.receiver_mobile=="")?row.receiver_mobile:row.receiver_telno,
				'phone': !(row.receiver_telno=="")?row.receiver_telno:row.receiver_mobile
			};
			customArea_data.sender = {
				"address": {
					"city": row.city,
					"detail": row.address,
					"district": row.district,
					"province": row.province,
					"town": row.town
				},
				"mobile": row.mobile,
				"name": row.contact,
				"phone": row.telno
			};
			customArea_data.goods = this.goodsInfoToArray(detail[row.id]);
			var print_data = [{
				'documentID' : data.waybill_info.waybillCode,
				'contents' : [{
					'templateURL' : data.templateURL,
					'signature' : data.signature,
					'data' : data.waybill_info
				},{
					'templateURL' : templateUrl,
					'data' : customArea_data
				}]
			}];
			return print_data;
		},
		goodsInfoToArray : function (goods_info){
			var goods = {'detail':[]};
			goods.suite_ids = goods_info.suite_ids;
			goods.suite_info = goods_info.suite_info;
			delete goods_info.suite_ids;
			delete goods_info.suite_info;
			for(var i=0;;i++){
				if(goods_info[i] == undefined)
					break;
				goods.detail[i] = goods_info[i];
			}
			goods.suite_info = goods.suite_info == undefined?"":goods.suite_info.substr(0,goods.suite_info.length-1);
			return goods;
		},
		setExamineConf : function(){
			open_menu(this.params.set_conf.title,this.params.set_conf.url);
		},
		playSuccessSound : function(){
			if(global_is_play_sound)
				$('#success_sound')[0].play();
		},
		playWarnSound : function(){
			if(global_is_play_sound)
				$('#warn_sound')[0].play();
		}
	};
	StockoutExamine.initFormSelectorList = function(form_id){
		this.form_selector_list = {
			'trade_no' 					: $('#'+form_id+' :input[name="trade_no"]'),
			'shop_name' 				: $('#'+form_id+' :input[name="shop_name"]'),
			'scan_class' 				: $('#'+form_id+' :input[name="scan_class"]'),
			'stockout_id' 				: $('#'+form_id+' :input[name="stockout_id"]'),
			'stockout_no' 				: $('#'+form_id+' :input[name="stockout_no"]'),
			'barcode_or_trade_no' 		: $('#'+form_id+' :input[name="barcode_or_trade_no"]'),
			'consign_examine' 			: $('#'+form_id+' a[name="consign_examine"]'),
//			'select_printer' 			: $('#'+form_id+' a[name="select_printer"]'),
			'order_goods_num' 			: $('#'+form_id+' strong[name="order_goods_num"]'),
			'scan_goods_num' 			: $('#'+form_id+' strong[name="scan_goods_num"]'),
			'message_info' 				: $('#'+form_id+' strong[name="message_info"]'),
			'print_examine_num'     	: $('#'+form_id+' strong[name="print_examine_num"]'),
			'pic_preview' 				: $('#stock_out_examine_config_value :input[name="pic_preview"]'),
			'sound_prompt' 				: $('#stock_out_examine_config_value :input[name="sound_prompt"]'),
			'quick_examine' 			: $('#stock_out_examine_config_value :input[name="quick_examine"]'),
			'examine_print_logistics'	: $('#stock_out_examine_config_value :input[name="examine_print_logistics"]'),
		};
	};
	$(function(){
		StockoutExamine.initFormSelectorList("<?php echo ($id_list["form"]); ?>");
		$('#stock_out_examine_config').combo({
			//required:false,
			editable:false,
			multiple:true
		}).combo('setText', '	点	击	配	置');
		$('#stock_out_examine_config_value').appendTo($('#stock_out_examine_config').combo('panel'));
		$('#stock_out_examine_config_value input').click(function(){
			var value = $(this).val();
			$('#stock_out_examine_config').combo('setValue', value).combo('setText', '	点	击	配	置').combo('hidePanel');
		});
		StockoutExamine.form_selector_list.pic_preview.click(function(){
			var that = this;
			var mode = 'Stock/SalesStockoutExamine';
			var key = 'salesstockoutexamine';
			//var url="<?php echo U('Setting/DatagridField/getDatagridField');?>";
			//url += (url.indexOf('?') != -1) ? '&mode='+mode+'&key='+key+'&frozen='+frozen : '?mode='+mode+'&key='+key+'&frozen='+frozen;
			$.post("<?php echo U('Stock/SalesStockoutExamine/getFields');?>", {mode:mode,key:key}, function(datas){
				var data={};
				var fields={};
				var pic_value = $(that).prop('checked');
				for(var k in datas){
					fields[(datas[k]['field'])] = "1-0";
				}
				if(pic_value){data['pic_name'] = "1-0";}else{data['pic_name'] = "0-0";}
				data = $.extend(fields, data);
				$.post("<?php echo U('Setting/DatagridField/setField');?>", {code:'stock_salesstockoutexamine_salesstockoutexamine', fields:data}, function(res){
					var opts=$('#'+stockoutExamine.params.datagrid.id).datagrid('options');
					if(opts.frozenColumns[0]!=undefined){var all=opts.columns[0].concat(opts.frozenColumns[0]);}else{var all=opts.columns[0];}
					var all_col=[];
					for(var i in all){
						all_col[all[i]['field']]=all[i];
					}
					var columns=[];
					var frozens=[];
					var col=[];
					for(k in data){
						col=data[k].split('-');
						all_col[k]['hidden']=(col[0]==1?0:1);
						if(col[1]==1&&all_col[k]){
							frozens.push(all_col[k]);
						}else{
							columns.push(all_col[k]);
						}
					}
					opts.frozenColumns[0]=frozens;
					opts.columns[0]=columns;
					//$('#'+dialog_id).dialog('close');
					$('#'+stockoutExamine.params.datagrid.id).datagrid(opts);
					if(global_trade_no != null)
						stockoutExamine.getStockoutOrderInfo(global_trade_no);
				});
			});
		});
		StockoutExamine.form_selector_list.sound_prompt.click(function(){
			var sound_value = $(this).prop('checked');
			if(sound_value){global_is_play_sound = 1;}else{global_is_play_sound = 0;}
			$.post("<?php echo U('Stock/SalesStockoutExamine/setPromptSound');?>", {promptSound:global_is_play_sound});
		});
		StockoutExamine.form_selector_list.quick_examine.click(function(){
			var quick_examine_value = $(this).prop('checked');
			if(quick_examine_value){global_is_quick_examine = 1;}else{global_is_quick_examine = 0;}
			$.post("<?php echo U('Stock/SalesStockoutExamine/setQuickExamine');?>", {quickExamine:global_is_quick_examine});
		});
		StockoutExamine.form_selector_list.examine_print_logistics.click(function(){
			var examine_print_logistics_value = $(this).prop('checked');
			if(examine_print_logistics_value){
				global_is_print_logistics = 1;
//				StockoutExamine.form_selector_list.select_printer.linkbutton({disabled:false});
			}else{
				global_is_print_logistics = 0;
//				StockoutExamine.form_selector_list.select_printer.linkbutton({disabled:true});
			}
			$.post("<?php echo U('Stock/SalesStockoutExamine/setExaminePrintLogistics');?>", {examinePrintLogistics:global_is_print_logistics});
		});
		setTimeout(function(){
			stockoutExamine = new StockoutExamine(JSON.parse('<?php echo ($params); ?>'),StockoutExamine.form_selector_list);
			stockoutExamine.initShow();
			stockoutExamine.connectStockWS();
			$('#'+stockoutExamine.params.datagrid.id).datagrid('enableCellEditing');
		},0);
	});
})();
</script>

<!-- layout-south-tabs, call add_tabs js function to add tabs -->


</body>
</html>