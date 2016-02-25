<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2016-01-15 14:27:00, compiled from ../app/web/template/test/test.htm */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>数据测试</title>
<style type="text/css"> 
	* {
		margin:0;
		padding:0;
	}
	body {
		background-color:lavender;
		}
	h1 {
		margin-top:5px;
		text-align:center;
	} 
	a { 
		text-decoration:none;
		margin:0 5px; 
		}
	.navigation {
		height:650px;
		weight:20%;
		border:1px solid black;
		float:left;
	}
	.content {
		height:650px;
		border:1px solid black;
		float:left;
		position：relative;
	}
	.data {	
		height:615px;
	}
	.controller {
		text-align:center;
		font-size:12px;
		clear:both;
	}
	table {
		border:solid #33CCFF;
		border-width:1px 0px 0px 1px;
		height:598px;
		width:100%;
		text-align:center;
		font-size:12px;'
	}
	tr {
		height:38px;
	}
	td {
		border:solid #33CCFF; border-width:0px 1px 1px 0px;
	}
	.single {
		background-color:#CCCCFF;
	}
	.multiple {
		background-color:#EEFFBB;
	}
	.time {width:15%;}	.user_agent {width:43%;}	.terminal{width:7%}	.platform{width:10%}	.device_model{width:15%}	.user_browser{width:10%}
	
</style>
<script type="text/javascript">
	function mouseOver(o) {
		o.style.backgroundColor = "#DDDDDD";
	}
	function mouseOut(o) {
		if((o.id%2)==1){
			o.style.backgroundColor = "#CCCCFF";
		}else{
			o.style.backgroundColor = "#EEFFBB";		
		}
	}
</script>
</head>
<body>
	<div class='header'><?php include('../app/data/template_c/test/header.tpl.php'); ?></div>
	<div style="border-bottom:1px solid black;height:50px;margin-top:-40px"></div>
		<div class="navigation"><?php include('../app/data/template_c/test/navigation.tpl.php'); ?></div>
		<div class="content">
			<div class='data'>
				<table>
					<tr class='multiple' id="0" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'>时间</td><td class='user_agent'>日志源数据</td><td class='terminal'>终端</td><td class='platform'>系统平台</td><td class='device_model'>手机型号</td><td class='browser'>浏览器型号</td>
					</tr>
					<tr class='single' id="1" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time0']; ?></td><td class='user_agent'><?php echo $this->view['user_agent0']; ?></td><td class='terminal'><?php echo $this->view['terminal0']; ?></td><td class='platform'><?php echo $this->view['platform0']; ?></td><td class='device_model'><?php echo $this->view['device_model0']; ?></td><td class='browser'><?php echo $this->view['browser0']; ?></td>
					</tr>
					<tr class='multiple' id="2" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time1']; ?></td><td class='user_agent'><?php echo $this->view['user_agent1']; ?></td><td class='terminal'><?php echo $this->view['terminal1']; ?></td><td class='platform'><?php echo $this->view['platform1']; ?></td><td class='device_model'><?php echo $this->view['device_model1']; ?></td><td class='browser'><?php echo $this->view['browser1']; ?></td>
					</tr>
					<tr class='single' id="3" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time2']; ?></td><td class='user_agent'><?php echo $this->view['user_agent2']; ?></td><td class='terminal'><?php echo $this->view['terminal2']; ?></td><td class='platform'><?php echo $this->view['platform2']; ?></td><td class='device_model'><?php echo $this->view['device_model2']; ?></td><td class='browser'><?php echo $this->view['browser2']; ?></td>
					</tr>
					<tr class='multiple' id="4" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time3']; ?></td><td class='user_agent'><?php echo $this->view['user_agent3']; ?></td><td class='terminal'><?php echo $this->view['terminal3']; ?></td><td class='platform'><?php echo $this->view['platform3']; ?></td><td class='device_model'><?php echo $this->view['device_model3']; ?></td><td class='browser'><?php echo $this->view['browser3']; ?></td>
					</tr>
					<tr class='single' id="5" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time4']; ?></td><td class='user_agent'><?php echo $this->view['user_agent4']; ?></td><td class='terminal'><?php echo $this->view['terminal4']; ?></td><td class='platform'><?php echo $this->view['platform4']; ?></td><td class='device_model'><?php echo $this->view['device_model4']; ?></td><td class='browser'><?php echo $this->view['browser4']; ?></td>
					</tr>
					<tr class='multiple' id="6" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time5']; ?></td><td class='user_agent'><?php echo $this->view['user_agent5']; ?></td><td class='terminal'><?php echo $this->view['terminal5']; ?></td><td class='platform'><?php echo $this->view['platform5']; ?></td><td class='device_model'><?php echo $this->view['device_model5']; ?></td><td class='browser'><?php echo $this->view['browser5']; ?></td>
					</tr>
					<tr class='single' id="7" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time6']; ?></td><td class='user_agent'><?php echo $this->view['user_agent6']; ?></td><td class='terminal'><?php echo $this->view['terminal6']; ?></td><td class='platform'><?php echo $this->view['platform6']; ?></td><td class='device_model'><?php echo $this->view['device_model6']; ?></td><td class='browser'><?php echo $this->view['browser6']; ?></td>
					</tr>
					<tr class='multiple' id="8" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time7']; ?></td><td class='user_agent'><?php echo $this->view['user_agent7']; ?></td><td class='terminal'><?php echo $this->view['terminal7']; ?></td><td class='platform'><?php echo $this->view['platform7']; ?></td><td class='device_model'><?php echo $this->view['device_model7']; ?></td><td class='browser'><?php echo $this->view['browser7']; ?></td>
					</tr>
					<tr class='single' id="9" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time8']; ?></td><td class='user_agent'><?php echo $this->view['user_agent8']; ?></td><td class='terminal'><?php echo $this->view['terminal8']; ?></td><td class='platform'><?php echo $this->view['platform8']; ?></td><td class='device_model'><?php echo $this->view['device_model8']; ?></td><td class='browser'><?php echo $this->view['browser8']; ?></td>
					</tr>
					<tr class='multiple' id="10" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time9']; ?></td><td class='user_agent'><?php echo $this->view['user_agent9']; ?></td><td class='terminal'><?php echo $this->view['terminal9']; ?></td><td class='platform'><?php echo $this->view['platform9']; ?></td><td class='device_model'><?php echo $this->view['device_model9']; ?></td><td class='browser'><?php echo $this->view['browser9']; ?></td>
					</tr>
					<tr class='single' id="11" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time10']; ?></td><td class='user_agent'><?php echo $this->view['user_agent10']; ?></td><td class='terminal'><?php echo $this->view['terminal10']; ?></td><td class='platform'><?php echo $this->view['platform10']; ?></td><td class='device_model'><?php echo $this->view['device_model10']; ?></td><td class='browser'><?php echo $this->view['browser10']; ?></td>
					</tr>
					<tr class='multiple' id="12" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time11']; ?></td><td class='user_agent'><?php echo $this->view['user_agent11']; ?></td><td class='terminal'><?php echo $this->view['terminal11']; ?></td><td class='platform'><?php echo $this->view['platform11']; ?></td><td class='device_model'><?php echo $this->view['device_model11']; ?></td><td class='browser'><?php echo $this->view['browser11']; ?></td>
					</tr>
					<tr class='single' id="13" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time12']; ?></td><td class='user_agent'><?php echo $this->view['user_agent12']; ?></td><td class='terminal'><?php echo $this->view['terminal12']; ?></td><td class='platform'><?php echo $this->view['platform12']; ?></td><td class='device_model'><?php echo $this->view['device_model12']; ?></td><td class='browser'><?php echo $this->view['browser12']; ?></td>
					</tr>
					<tr class='multiple' id="14" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
						<td class='time'><?php echo $this->view['time13']; ?></td><td class='user_agent'><?php echo $this->view['user_agent13']; ?></td><td class='terminal'><?php echo $this->view['terminal13']; ?></td><td class='platform'><?php echo $this->view['platform13']; ?></td><td class='device_model'><?php echo $this->view['device_model13']; ?></td><td class='browser'><?php echo $this->view['browser13']; ?></td>
					</tr>
				</table>
			</div>
			<div class='controller'>
				<a href="javascript:;" onclick="">首页</a><a href="javascript:;" onclick="">上一页</a><a href="javascript:;" onclick="">下一页</a><a href="javascript:;" onclick="">尾页</a><p>第<span id="CPN">1</span>页/共<?php echo $this->view['TotalPageNum']; ?>页</p>
			</div>
		</div>
	</div>
</body>
</html>