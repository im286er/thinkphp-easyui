<?php if (!defined('THINK_PATH')) exit();?><table id="Core_Db"></table>
<script type="text/javascript">
window.Core_Db = {
	//工具栏
	toolbar: [
		{ text: '备份数据库', iconCls: 'icons-table-table_refresh', handler: function(){alert("后续完善");} },
		{ text: '还原数据库', iconCls: 'icons-table-table_refresh', handler: function(){alert("后续完善");} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '优化全部表', iconCls: 'icons-table-table_refresh', handler: function(){Core_Db.seoDb("all")} },
		{ text: '修复全部表', iconCls: 'icons-table-table_refresh', handler: function(){Core_Db.repairDb("all")} },
	],
	opert: function(value,row){
		return "<a href='javascript:void(0)' onclick='Core_Db.repairDb(\"one\",\""+row['name']+"\")'>修复表</a> | <a href='javascript:void(0)' onclick='Core_Db.seoDb(\"one\",\""+row['name']+"\")'>优化表</a>";
	},
	dataLength: function(value){
		var length = (value / 1024 / 1024).toFixed(2);
		return length+" MB";
	},
	//优化表
	seoDb: function(type,table){
		var data = '';
		if(type == 'one'){
			data='type=one&table='+table;
		} else if(type == 'all'){
			data='type=all';
		} else {
			alert("优化参数不正确");
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo U("Core/seoDb");?>',
			data: data,
			dataType:"json",
			beforeSend: function(){
				$.messager.progress({text:'处理中，请稍候...'});
			},
			success: function(data){
				$.messager.progress("close");
				if(!data.status){
					$.Oa.tip('提示信息', data.info,'error');
				} else {
					$.Oa.tip('提示信息', data.info,'info');
					$($.Oa.dialog_1).dialog('close');
					$.Oa.refresh();
				}
			},
			error: function(data){
				$.messager.progress("close");
				$.Oa.tip('提示信息', data.responseText,'error');
			}
		});
	},
	//修复表
	repairDb: function(type,table){
		var data = '';
		if(type == 'one'){
			data='type=one&table='+table;
		} else if(type == 'all'){
			data='type=all';
		} else {
			alert("修复参数不正确");
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo U("Core/repairDb");?>',
			data: data,
			dataType:"json",
			beforeSend: function(){
				$.messager.progress({text:'处理中，请稍候...'});
			},
			success: function(data){
				$.messager.progress("close");
				if(!data.status){
					$.Oa.tip('提示信息', data.info,'error');
				} else {
					$.Oa.tip('提示信息', data.info,'info');
					$($.Oa.dialog_1).dialog('close');
					$.Oa.refresh();
				}
			},
			error: function(data){
				$.messager.progress("close");
				$.Oa.tip('提示信息', data.responseText,'error');
			}
		});
	}
}
</script>
<script>
/**
 * 数据容器实例化数据
 */
$("#Core_Db").datagrid({
	title: "系统中心 > 后台设置 > 数据管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Db.toolbar,
	idField: 'id',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Core/Db');?>",
	columns:[[
		{field:'name',title:'表名',width:80},
		{field:'rows',title:'记录数',width:80},
		{field:'data_length',title:'已使用大小',width:80,formatter:Core_Db.dataLength},
		{field:'create_time',title:'创建时间',width:80},
		{field:'collation',title:'字符集',width:80},
		{field:'engine',title:'表引擎',width:80},
		{field:'opert',title:'操作',width:80,formatter:Core_Db.opert}
	]]
});
</script>