<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.easyui.min.js"></script>
</head>
<body>
<div class="easyui-layout" data-options="fit:true" style="width:100%;height:100%;overflow:hidden;" id="panel_layout">
	<div data-options="region:'west',split:true" style="width:23%;height:100%;overflow:hidden;">
			<table style="width:90%;height:100%;overflow:auto;" id="new_logistics_print_template_dg" class="easyui-datagrid" data-options="fit:false"></table>
		<div id="new_logistics_print_template_tb" style="padding:5px;height:auto;">
			<div>
			<a class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" data-step="1" data-intro="可以从这里下载想要的模板" href="javascript:void(0)" 
			   onclick="downloadTemplatesDialog()">下载模板</a>
			<a class="easyui-linkbutton !important" data-options="iconCls:'icon-edit',plain:true" data-step="2" data-intro="可以从这里编辑模板" href="http://cloudprint.cainiao.com"
			   target="_blank">编辑模板</a>
			   <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-no',plain:true"
			   onclick="deleteTemplate()">删除模板</a>
			</div>
			<label>模板类型：</label>
		<!-- <input id="selectTemplatesType" class="easyui-combobox" data-options="valueField: 'id',textField: 'text',data:[{'id':'7','text':'E快帮菜鸟模板'},{'id':'6','text':'E快帮非菜鸟模板'},{'id':'5','text':'自定义非菜鸟模板'},{'id':'4','text':'自定义菜鸟模板'}],onSelect:function(rec){getTemplates(rec.id);},value:7" />  -->
		<input id="selectTemplatesType" class="easyui-combobox" data-options="valueField: 'id',textField: 'text',width:'148',data:[{'id':'8','text':'菜鸟模板'},{'id':'9','text':'非菜鸟模板'}],onSelect:function(rec){getTemplates(rec.id);},value:8" />
			<div id="logisticsTypeSelect">
			<label>物流名称：</label>
			<input id="logisticsTypeSelectCombobox" class="easyui-combobox" data-options="valueField:'id',textField:'name',width:'148',data:<?php echo ($logistics_list); ?>,value:0,onSelect:function(res){changeLogistics(res.id);}">
			</div>
			<div id="templateTypeSelect" style="display:none">
			<label>模板名称：</label>
			<input id="templateTypeSelectCombobox"  class="easyui-combobox" data-options="valueField:'url',textField:'name',width:'148',onSelect:function(res){changeTemplate();}">
			</div>
			<input type="text" name="oldType" value="0" style="display:none">
			<input type="text" name="templatesURL" value="<?php echo ($templateIndex); ?>" style="display:none">
			<input type="text" name="isFirstOpen" value="0" style="display:none">
		</div>
	</div> 
 
<div id="logisticsTemplatesDialog"></div>
<div data-options="region:'east',split:true" style="width:80%;height:107%;overflow:hidden;background:#E0ECFF;float:right;">
	<div style="width:89%;height:100%;overflow:hidden;margin-left:10%">
	<iframe src="" showIframe="template" frameborder="0"  style="width:109%;height:100%;"></iframe>
	</div> 
</div></div>
<div style="top:-100%;float:right;position:relative">
	<span style="margin-right: 76px;">开关新手引导：</span>
		<div id="templateHelpGuideFlag1" class="open1" style="left: 92px;top: -20px;">
        	<div id="templateHelpGuideFlag2" class="open2"></div>
    	</div>
</div>
    <style type="text/css">
    #templateHelpGuideFlag1{
        width: 61px;
        height: 20px;
        border-radius: 50px;
        position: relative;
    }
    #templateHelpGuideFlag2{
        width: 20px;
        height: 20px;
        border-radius: 48px;
        position: absolute;
        background: white;
        box-shadow: 0px 1px 1px rgba(0,0,0,0.4);
    }
    .open1{
        background: rgba(134, 200, 222,0.8);
    }
    .open2{
        top: -1px;
        right: 1px;
    }
    .close1{
        background: rgba(255,255,255,0.4);
        border:1px solid rgba(0,0,0,0.15);
        border-left: transparent;
    }
    .close2{
        left: 0px;
        top: 0px;
        border:0px solid rgba(0,0,0,0.1);
    }
    </style>
<script>
//# sourceURL=new_print_template.js
	var templatesWs;
	$(function(){
		var div2=document.getElementById("templateHelpGuideFlag2");
        var div1=document.getElementById("templateHelpGuideFlag1");
        if(<?php echo ($num); ?>>0){
        	div1.className = "close1";
        	div2.className = "close2";
        }
        div2.onclick=function(){
          div1.className=(div1.className=="close1")?"open1":"close1";
          div2.className=(div2.className=="close2")?"open2":"close2";
          if(div1.className == "open1")
          	introJs().setOptions({'doneLabel':'跳过','prevLabel':'上一步','nextLabel':'下一步','skipLabel':'跳过'}).start();
        }
		connectTemlatesWS();
		setTimeout(function(){
		getTemplates($('#selectTemplatesType').combobox('getValue'));
			if(<?php echo ($num); ?>==0){
				introJs().setOptions({'doneLabel':'跳过','prevLabel':'上一步','nextLabel':'下一步','skipLabel':'跳过'}).start();
			}
		},10);
	});
	
function getTemplates(type){
	if(type == 8 && $('input[name=isFirstOpen]').val() != 0){
		//$('#templateTypeSelect').show();
		$('input[name=isFirstOpen]').val("1");
	}else if(type == 8){
		$('#logisticsTypeSelect').show();
		$('input[name=isFirstOpen]').val("1");
	}
	else if(type == 9){
		$('#logisticsTypeSelectCombobox').combobox('setValue','0');
		//$('#templateTypeSelect').hide();
		$('#logisticsTypeSelect').hide();
		$('input[name=isFirstOpen]').val("0");
	}
	$('#new_logistics_print_template_dg').datagrid({
				singleSelect: true,
				toolbar: '#new_logistics_print_template_tb',
				url: '/index.php/Setting/NewPrintTemplate/getTemplateList/type/'+type,
				onClickRow: clickRow,
				//remoteSort: false,
				columns:[[{field: 'rec_id', hidden: true,},
						  {field: 'title', title: '模板名称',width:120,editor:{type:'validatebox',options:{required: true}}},
						  {field: 'content', hidden: true,width:40},
						  {field: 'modified', title: '修改时间'}
						  ]]
			});
}
function clickRow(index,row){
	connectTemlatesWS();
	var content = JSON.parse(row.content);

	var date = new Date();
	var data_stander = {
		templateURL : content.user_std_template_url,
		data : {
			"recipient": {
	            "address": {
	              "city": "北京市",
	              "detail": "收货地址花家地社区卫生服务站三层楼我也不知道是哪儿了",
	              "district": "朝阳区",
	              "province": "北京",
	              "town": "望京街道"
	            },
	            "mobile": "1326443651",
	            "name": "张三",
	            "phone": "057123221"
          	},
          	"routingInfo": {
	            "consolidation": {
	              "name": "杭州",
	              "code": "hangzhou"
	            },
	            "origin": {
	              "code": "POSTB"
	            },
	            "sortation": {
	              "name": "杭州"
	            },
            	"routeCode": "380D-56-04"
          },
          "sender": {
	            "address": {
	              "city": "北京市",
	              "detail": "发货地址花家地社区卫生服务站二层楼我也不知道是哪儿了",
	              "district": "朝阳区",
	              "province": "北京",
	              "town": "望京街道"
	            },
	            "mobile": "1326443652",
	            "name": "张三",
	            "phone": "057123222"
          },
          "shippingOption": {
	            "code": "COD",
	            "services": {
	              "SVC-COD": {
	                "value": "200"
	              }
	            },
	            "title": "代收货款"
          },
          "waybillCode": "9890000160004"
		}
	};
	var data_custom = {
		templateURL : content.custom_area_url,
		data : {
			sender : {
				  "address" : {
					  "city": "北京市",
		              "detail": "发货地址花家地社区卫生服务站二层楼我也不知道是哪儿了",
		              "district": "朝阳区",
		              "province": "北京",
		              "town": "望京街道"
		          },
	              "mobile": "1326443652",
		          "name": "张三",
		          "phone": "057123222"
			},
			recipient : {
				"address" : {
					"city": "北京市",
		            "detail": "收货地址花家地社区卫生服务站三层楼我也不知道是哪儿了",
		            "district": "朝阳区",
		            "province": "北京",
		            "town": "望京街道"
		        },
	             "mobile": "1326443651",
	             "name": "李四",
	             "phone": "057123221"
			},
			trade:{
				trade_no : "JY201608200001",
				src_tids : "12121211",
				logistics_no : "9890000160004",
				package_code : '9890000160004-1-1-',
				package_id : "245",
				goods_amount : "1680",
                receivable : "234",
				print_date : (new Date()).getFullYear()+"-"+((new Date()).getMonth()+1)+"-"+(new Date()).getDate(),//(new Date()).toLocaleString().replace(/\//g,"-").substring(0,9),
				trade_time : "201608080808",
				buyer_message : '发顺丰',
				buyer_nick : '薛定猫的鄂',
				invoice_title : '发票抬头',
				invoice_content : '发票内容',
				receiver_dtb : '010',
				cs_remark : '我是卖家留言',
				cod_amount : 0
			},
			shop : {
				name : "有间小店",
				url : "http://test.html",
			},
			goods :{
						amount : '2',
						detail : [{
							no   : 1,
							goods_name : "book",
							spec_name : "本",
							num : '5',
							price : '12',
							spec_no : 'TEST04922',
							goods_no : '00004922',
							spec_code : 'spec_4922',
							position_no : 'A2322'
						},{
							no    : 2,
							goods_name : "toy",
							spec_name : "个",
							num : '2',
							price : '31',
							spec_no : 'TEST00000',
							goods_no : '00000000',
							spec_code : 'spec_0000',
							position_no : 'B1211',
					}],
					suite_ids:',1,2',
					suite_info:'组合装1   1.00;组合装2   2.00;单品1   1.00'
		}
		}
	};
	var data_custom_barcode = {
		templateURL : content.custom_area_url,
		data : {
			goodsbarcode :{
						merchant_no : '商家编码0001',
						goods_no   : '货品编码0001',
						goods_name : "货品名称0001",
						spec_name : "规格名称_蓝色",
						spec_code : '规格编码_blue',
						short_name : '简称_01',
						barcode : 'barcode001',
						is_suite : '否'
			}
		}
	};
	var contents = [];
	var type = $('#selectTemplatesType').combobox('getValue');
	//if($.isEmptyObject(content.user_std_template_url))
	if(type==5||type==6||type==9)
		if(row.title.search(/^条码打印_/)!=-1){
			contents[0] = data_custom_barcode;
		}else{
			contents[0] = data_custom;
		}

	//else if($.isEmptyObject(content.custom_area_url)) 
	else if((type==7||type==8)&&$.isEmptyObject(content.user_std_template_url)){
		$('#templateTypeSelectCombobox').combobox('enable');
		data_stander.templateURL = "http://cloudprint.cainiao.com/template/standard/1501/48";
		if($('#templateTypeSelectCombobox').combobox('getValue').length>4)
			data_stander.templateURL = $('#templateTypeSelectCombobox').combobox('getValue');
		if($('#templateTypeSelectCombobox').combobox('getText').indexOf("三联")>-1){
			contents = [data_stander];
		}
		else
			contents = [data_stander,data_custom];
		}
	else {
		contents = [data_stander,data_custom];
		$('#templateTypeSelectCombobox').combobox('disable');
	}
	var request = {
		cmd : "print",
        requetid : "12345678901234567890",
        version : "1.0",
        task : {
            taskID : ''+ parseInt(1000*Math.random()) + "111",
            preview : true,
            printer : '',
            previewType : 'image', 
            documents: [{
            	documentID : "9890000160004",
            	contents : contents//[data_stander,data_custom]
            }]
        }
	};
	templatesWs.send(JSON.stringify(request));
}
function connectTemlatesWS(){	
	if($.isEmptyObject(templatesWs)){
		templatesWs = new WebSocket("ws://127.0.0.1:13528");
		templatesWs.onmessage = onTemplatesMessage;
		templatesWs.onerror = onTemplatesError;
	}
}
function onTemplatesMessage(event){
	var ret = $.parseJSON(event.data);
	if(!$.isEmptyObject(ret)){
		switch(ret.cmd){
			case 'print':
			var taskID = ret.taskID+"";
			taskID = taskID.substr(taskID.length-3,taskID.length);
			if(taskID==111||taskID==121)
			{
				var preview = ret.previewURL;
				if(!$.isEmptyObject(preview))
					window.open(ret.previewURL);
				preview = ret.previewImage;
				if(!$.isEmptyObject(preview)&&(preview.length != 0))
					$('iframe[showIframe=template]').attr("src",ret.previewImage[0]);
					}
			break;
		}
	}
}
function onTemplatesError(){
	templatesWs = null;
	$('#reason_show_dialog').dialog({    
    title: '打印组件错误',    
    width: 400,    
    height: 200,    
    closed: false,    
    cache: false,    
    href:  "<?php echo U('Stock/StockSalesPrint/onWSError');?>",    
    modal: true   
	});    
	$('#reason_show_dialog').dialog('refresh', "<?php echo U('Stock/StockSalesPrint/onWSError');?>");
}
function downloadTemplatesDialog(){
	introJs().exit();
	$.post("<?php echo U(hasAuthShop);?>",{},function(ret){
		if(ret.status != 0){
			messager.alert(ret.msg);
		}else{
			if(ret.shopNo > 0){
				$('#logisticsTemplatesDialog').dialog({
					title : "模板下载",
					width: 250,    
				    height: 404,    
				    closed: false,    
				    href: "<?php echo U('NewPrintTemplate/downloadTemplates');?>",    
				    modal: true ,
				    toolbar:[{text:'全选',iconCls:'icon-ok',handler:SelectAllTemplates},{text:'反选',iconCls:'icon-redo',handler:selectInvert},{text:'下载',iconCls:'icon-download',handler:downloadTemplates
					}]
				});
			}else {
				messager.alert("您没有授权过的淘宝店铺，请去店铺页面中授权！");
			}
		}
	});
	
}
function getTemplatesList(shopId,templateType){
	if(templateType == undefined||templateType == "")
		templateType = $("select[comboname=templateType]").combobox("getValue");
	if(shopId == undefined||shopId == "") shopId = $("select[comboname=shop]").combobox("getValue");
	if(templateType == 100) return ;
	$.post("<?php echo U(getTemplates);?>",{shopId:shopId,templateType:templateType},function(ret){
		if(ret.status == 1){
			messager.alert(ret.msg);
			$("#templateList_datagrid").datagrid({data:[]});
		}else if(ret.status == 2){
			$.fn.richDialog("response", ret.fail, "print_template");
			$("#templateList_datagrid").datagrid({
				data:ret.success,
				columns:[[
        			{field:'template_id',hidden:true},
       				{field:'template_name',title:'模板名称',width:220,align:'left'}
				]]
			});
		}else {
			$("#templateList_datagrid").datagrid({
				data:ret,
				columns:[[
        			{field:'template_id',hidden:true},
        			{field:'template_name',title:'模板名称',width:220,align:'left'}
    			]]
			});
		}
	});
}
function downloadTemplates(){
	var templates = $("#templateList_datagrid").datagrid('getChecked');
	if(templates.length == 0){
		messager.alert("请选择模板");
		return;
	}
	var templateType = $("select[comboname=templateType]").combobox("getValue");
	var shopId = $("select[comboname=shop]").combobox("getValue");
	var oldShopId = $("input[name=oldShopId]").val();
	var oldRecId = $("input[name=oldRecId]").val();
	$.post("<?php echo U(saveTemplates);?>",{templates:JSON.stringify(templates),templateType:templateType,shopId:shopId,oldShopId:oldShopId,oldRecId:oldRecId},function(ret){
		if(ret.status == 0){
			messager.info("模板下载成功！");
			$('#logisticsTemplatesDialog').dialog('close');
			$('#new_logistics_print_template_dg').datagrid('reload');
		}
		else {
			messager.alert("模板下载失败，请联系管理员！");
		}
	});
}
function SelectAllTemplates(){
	$('#templateList_datagrid').datagrid('selectAll');
}
function deleteTemplate(){
	var row = $('#new_logistics_print_template_dg').datagrid('getSelections')[0];
	if($.isEmptyObject(row)){
		messager.alert("请选择要删除的模板");
		return;
	}
	var rec_id = row.rec_id;
	messager.confirm("您确定要删除该模板吗？",function(r){
		if(r){
			$.post("<?php echo U(deleteTemplate);?>",{rec_id:rec_id},function(ret){
				if(ret.status == 0){
					$('#new_logistics_print_template_dg').datagrid('reload');
				}else{
					messager.alert(ret.msg);
				}
			});
		}
	});
	
}
function changeLogistics(logisticsId){
	var oldType = $('input[name=oldType]').val();
	var stdTemplate = getAllStdTemplates();
	var logisticsInfo = $('#logisticsTypeSelectCombobox').combobox('getData');
	var logisticsId = $('#logisticsTypeSelectCombobox').combobox('getValue');
	var type;
	for(var i in logisticsInfo){
		if(logisticsInfo[i].id == logisticsId)
			type = logisticsInfo[i].type;
	}
	if(type == oldType)
		return;
	$('#new_logistics_print_template_dg').datagrid('load','/index.php/Setting/NewPrintTemplate/getTemplateList/type/8/logisticsType/'+type);
	var logisticsCode = <?php echo ($logisticsCode); ?>;
	var code = type==0?0:logisticsCode[type];
	//type == 0?$('#templateTypeSelect').hide():$('#templateTypeSelect').show();
	if(type != 0){
		for(var i in stdTemplate){
			if(stdTemplate[i].cp_code == code){
				setTemplateType(stdTemplate[i].standard_templates.standard_template_do,type);
				changeTemplate();
			}
		}
	}
/*	$.post("<?php echo U('PrintTemplate/getTemplatesOnLogisticsCh');?>",{oldId:oldId,newId:logisticsId},function(res){
		if(res.status == 0){
			setTemplateType(res.success,type);
			changeTemplate();
		}
	});*/
}

function setTemplateType(templateInfo,logisticsType){
	var template,data=[] ;
	for(var i in templateInfo){
		template = templateInfo[i];
		data[i] = {
			'name':template.standard_template_name,
			'url':template.standard_template_url
				};
	}
	//$('#templateTypeSelect').show();
	$('#templateTypeSelectCombobox').combobox('loadData',data);
	$('#templateTypeSelectCombobox').combobox('setValue',data[0].url);
	$('input[name=oldType]').val(logisticsType);
}
function getAllStdTemplates(){
	return <?php echo ($template_list); ?>;
}
function changeTemplate(){
	if($.isEmptyObject($('#new_logistics_print_template_dg').datagrid('getSelections')))
		return;
	clickRow('',$('#new_logistics_print_template_dg').datagrid('getSelections')[0]);
}
function selectInvert(){
	var rows = $('#templateList_datagrid').datagrid('getSelections');
	$('#templateList_datagrid').datagrid('selectAll');
	for(var i in rows){
		$('#templateList_datagrid').datagrid('unselectRow',$('#templateList_datagrid').datagrid('getRowIndex',rows[i]));
	}
}
</script>
</body>
</html>