<?php if (!defined('THINK_PATH')) exit();?><table id="Core_BehaviorLog"></table>
<div id="Core_BehaviorLog_Search" style="padding:5px;height:auto">
	<form id="Core_BehaviorLog_Search_Form">
		用户：<input name="search[name]" class="easyui-textbox" style="width:100px">
		时 间: <input name="search[date_begin]" class="easyui-datebox" style="width:100px">
		至: <input name="search[date_end]" class="easyui-datebox" style="width:100px">
		<a href="javascript:;" onclick="Core_BehaviorLog.search()" class="easyui-linkbutton" iconCls
="icons-table-table">搜索</a>
		<a href="javascript:;" onclick="Core_BehaviorLog.delete()" class="easyui-linkbutton" iconCls="icons-table-table_delete"
>删除上月数据</a>
	</form>
</div>
<script type="text/javascript">
window.Core_BehaviorLog = {
	//工具栏
	toolbar: "#Core_BehaviorLog_Search",
	//搜索
	search: function(){
		$("#Core_BehaviorLog").datagrid('loadData', { total: 0, rows: [] });
		var queryParams = $("#Core_BehaviorLog").datagrid('options').queryParams;
		$.each($("#Core_BehaviorLog_Search_Form").serializeArray(), function() {
			queryParams[$(this).attr('name')] = $(this).attr('value');
		});
		$("#Core_BehaviorLog").datagrid({pageNumber: 1});
	},

	//删除上月数据
	delete: function(){
		$.Oa.confirm('$.Oa.delData("lastMonth","<?php echo U("Core/delBehaviorLog");?>")')
	},

	//显示附带参数
	view: function(obj){
		//查看
		var content = $(obj).html();
		content = Core_BehaviorLog.formatter(content);

		$($.Oa.dialog_1).dialog({
			title: '详细参数',
			iconCls: 'icons-application-application_view_detail',
			width: 380,
			height: 300,
			cache: false,
			href: null,
			content: '<pre>' + content + '</pre>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: true,
			maximizable: true
		});
	},

	//json字符显示格式化
	formatter: function(string){
		var result      = '',
			pos         = 0,
			prevChar    = '',
			outOfQuotes = true;

		for(var i=0; i<string.length; i++){
			var char = string.substring(i, i+1);
			if (char == '"' && prevChar != '\\') {
				outOfQuotes = !outOfQuotes;
			}else if((char == '}' || char == ']') && outOfQuotes) {
				result += "\n";
				pos--;
				for (j=0; j<pos; j++) result += '  ';
			}
			result += char;
			if ((char == ',' || char == '{' || char == '[') && outOfQuotes) {
				result += "\n";
				if (char == '{' || char == '[') pos++;
				for (j = 0; j < pos; j++) result += '  ';
			}
			prevChar = char;
		}
		return result;
	},

	//附带参数格式化
	json_data: function(val){
		return '<a href="javascript:void(0);" onclick="Core_BehaviorLog.view(this)">'+val+'</a>';
	},
}
</script>
<script>
/**
 * 版块容器实例化数据
 */
$("#Core_BehaviorLog").datagrid({
	title: "系统中心 > 日志设置 > 行为日志管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_BehaviorLog.toolbar,
	idField: 'id',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Core/BehaviorLog');?>",
	columns:[[
		{field:'name',title:'行为用户',width:30},
		{field:'controller_name',title:'行为名称',width:60},
		{field:'controller_action',title:'请求路径',width:60},
		{field:'json_data',title:'附带参数',formatter:Core_BehaviorLog.json_data,width:250},
		{field:'date',title:'时间',width:60},
		{field:'ip',title:'IP',width:50},
	]],
	pagination:true,
	pagePosition:'bottom',
	pageNumber:1,
	pageSize:20,
	pageList:[20,30,50]
});
</script>