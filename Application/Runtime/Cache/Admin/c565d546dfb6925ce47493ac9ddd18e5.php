<?php if (!defined('THINK_PATH')) exit();?><table id="Core_Setting" class="easyui-propertygrid" data-options="border:false,fit:true,showHeader:true,columns:[[{field:'name',title:'属性名称',width:50},{field:'value',title:'属性值',width:200}]],showGroup:true,scrollbarSize:0,title:'系统管理 &gt; 后台设置 &gt; 系统设置 &gt; ',url:'<?php echo U('System/Setting');?>',onClickRow:Core_Setting.onClickRow,toolbar:Core_Setting.toolbar"></table>

<script type="text/javascript">
var Core_Setting = {
	data: {},

	//工具栏
	toolbar: [
		{text: '更新', iconCls: 'icons-table-table_save', handler: function(){Core_Setting.edit();}},
		{text: '生成', iconCls: 'icons-other-xhtml_go', handler: function(){Core_Setting.write();}},
		{text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();}},
	],

	//记录当前选项的位置，失去焦点的时候可以用来定位
	onClickRow: function(index){
		Core_Setting.data = {index: index, field: 'value'};
	},

	//更新
	edit: function(){
		var data = [];
		var rows = $("#Core_Setting").propertygrid('getChanges');
		for(var i=0; i<rows.length; i++){
			data.push({'key': rows[i]['key'], 'value': rows[i]['value']});
		}

		$.messager.progress({text:'处理中，请稍候...'});
		$.post('<?php echo U("System/editSetting");?>', {data: data}, function(data){
			$.messager.progress('close');
			if(!data.status){
				$.Oa.tip('提示信息', data.info, 'error');
			}else{
				$.Oa.tip('提示信息', data.info, 'info');
				$.Oa.refresh();
			}
		}, 'json').error(function(){
            $.messager.progress({text:"保存配置失败，3秒后自动关闭..."});
            setTimeout('$.messager.progress("close")',3000);
		});
	},

	//写入
	write: function(){
		$.post('<?php echo U("System/writeSetting");?>','', function(data){
			$.messager.progress('close');
			if(!data.status){
				$.Oa.tip('提示信息', data.info, 'error');
			}else{
				$.Oa.tip('提示信息', data.info, 'info');
				$.Oa.refresh();
			}
		}, 'json').error(function(){
            $.messager.progress({text:"生成配置失败，3秒后自动关闭..."});
            setTimeout('$.messager.progress("close")',3000);
		});
	}
};
</script>