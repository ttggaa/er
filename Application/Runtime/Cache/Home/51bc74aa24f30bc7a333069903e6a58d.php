<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8"> 
<meta name="keywords " content="E快帮,E快帮ERP,旺店通,ERP,店铺管理,店铺管理ERP"/>
<title><?php echo C('SYSTEM_NAME');?>-欢迎登录</title>
<link rel="stylesheet" type="text/css" href="/Public/Css/login.css?v=<?php echo ($version_number); ?>">
<link rel="icon" href="/Public/Image/favicon.ico"  type="image/x-icon">
<script type="text/javascript" src="/Public/Js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.md5.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.cookie.js"></script>
<!--[if lt IE 9]>
<link rel="stylesheet" type="text/css" href="/Public/Css/login.2.css">
<script type="text/javascript" src="/Public/Js/json.2.js"></script>
<![endif]-->
<script type="text/javascript" src="/Public/Js/login.util.js?v=<?php echo ($version_number); ?>"></script>
</head>
<body>
<div class="main">
	<div id="body">
		<div id="content">
			<div id="logo"><a href="/index.php/home/login/login.html">
				<img alt="E快帮" src="/Public/Image/Login/login_logo_white.png" >
			</a>
				<a href="/index.php/home/login/login.html" id="logo-text">网上开店 找E快帮</a>
			</div>
			<div class="login-text">
				<span class="">E快帮网店管理SaaS软件</span><span>为您的店铺保驾护航</span>
				<div class="login-img">
					<img alt="云服务" src="/Public/Image/Login/login_img.png" >
					<img alt="云服务" src="/Public/Image/Login/shuobo_03.png" >
				</div>
			</div>
		</div>
		<div class="login-body">
			<div class="login-wrap">
				<div class="login-tab" style="border-radius: 3px;">
					<div class="login-form">
						<div class="top">欢迎登录E快帮</div>
						<div class="cell cell-1"><i class="input-icon"></i><input class="text" type="text" id="sid" name="sid" maxlength="25" placeholder="卖家账号"/></div>
						<div class="msg-err msg-err-sid"></div>
						<div class="cell cell-2"><i class="input-icon"></i><input class="text" type="text" id="username" name="username" maxlength="30" placeholder="用户名"/></div>
						<div class="msg-err msg-err-username"></div>
						<div class="cell cell-3"><i class="input-icon"></i><input class="text" type="password" id="password" name="password" maxlength="30" placeholder="密码"/></div>
						<!--<div class="cell2"><label style="display:inline-block;vertical-align: middle;color:#999;font-size: 12px;font-weight: normal;cursor:default;"><input class="checkbox" type="checkbox" id="autologin" name="autologin" onfocus="this.blur()"/>7天内自动登录</label></div>-->
						<div class="msg-err msg-err-password"></div>
						<div class="cell1"><a href="<?php echo U('Home/Login/reset');?>">忘记密码？</a></div>
						<div class="cell2"><a id="submit" href="#" class="button">登录</a></div>
						<div class="cell2 msg-err" id="login_msg-err"></div>
					</div>
				</div>
				<div class="login-bottom"><div class="copyright">©版权所有E快帮  服务热线:400-010-1039</div></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	//检测浏览器版本
	check_navigator();
	function check_navigator(){
		var userAgent=navigator.userAgent.toLowerCase();
		var appVersion=navigator.appVersion.toLowerCase();
		var status=1;
		if (!!window.ActiveXObject || "ActiveXObject" in window){
			if(appVersion.match(/msie 8./i)=="msie 8."){
				status=0;
			}else if(appVersion.match(/msie 7./i)=="msie 7."){
				status=0;
			}else if(appVersion.match(/msie 5./i)=="msie 5."){
				status=0;
			}
		}
		if(status==0){
			alert('当前浏览器版本无法正常使用本系统，请更换谷歌浏览器！');
		}
	}
	login.autoLogin();
	fancyForm.setup();
	$('#submit').bind('click',function(){login.doLogin();});
	$('.login-form .cell input').bind('keydown',function(e){if(e.keyCode==13){login.doLogin();}});
});
var login=function(){
	return{
		doLogin:function(isAutoLogin){
			//isAutoLogin=!isAutoLogin?false:true;
			isAutoLogin=false;
			var data={};
			data.sid=$('#sid').val();
			data.username=$('#username').val();
			data.password=$('#password').val();
			if(!checkLogin('sid',data,{info:'<i></i>卖家账号不能为空',err:'<i></i>非法卖家账号'},0)){return;}
			if(!checkLogin('username',data,{info:'<i></i>用户名不能为空',err:'<i></i>非法用户名'},1)){return;}
			if(!checkLogin('password',data,{info:'<i></i>密码不能为空'},2)){return;}
			if(!isAutoLogin){
				data.password = $.md5(data.password);
			}
			var userinfo=JSON.stringify(data);
			$.post("<?php echo U('Home/Login/access');?>", {data: userinfo}, function (res) {
		    	if (0 == res.status) {
		    		if(!isAutoLogin){
						if($('#autologin').is(':checked')){$.cookie('userinfo',userinfo,{expires:7, path:'/'});}
						else if($.cookie('userinfo')!=undefined){$.cookie('userinfo',null,{expires:-1, path:'/'});}
					}
		    		$.cookie('username',data.username,{expires:10, path:'/'});
		    		$.cookie('sid',data.sid,{expires:10, path:'/'});
					if(res.hasOwnProperty('valid_day')){
						var valid_day = res.valid_day;
						dl_alert('温馨提示',"您的账号有效期剩余"+valid_day+"天，请及时续费哟！",function(){
							window.location.href=res.info
						});
					}else{
						window.location.href=res.info;
					}
		        } else if (2 == res.status) {
					window.top.location = res.info;
				}else {
					try{
						showResultInfo(res.info);
					}catch (e){
						$('.msg-err').html('<i></i>'+res.info);
					}
		        }
		    });
		},
		autoLogin:function(){
			var isLogout='<?php echo ($logout); ?>';
			/* if(isLogout=='logout'&&$.cookie('userinfo')!=undefined){
				$.cookie('userinfo',null,{expires:-1, path:'/'});
			}else if($.cookie('userinfo')!=undefined){
				$('#autologin').attr('checked',true);
				var user=JSON.parse($.cookie('userinfo'));
				$('#username').val(user.username);
				$('#password').val(user.password);
				$('#sid').val(user.sid);
				this.doLogin(true);
				return;
			} */
			if($.cookie('username')!=undefined){
				$('#username').val($.cookie('username'));
			}
			if($.cookie('sid')!=undefined){
				$('#sid').val($.cookie('sid'));
			}
		}
	};
}();
</script>
</body>
</html>