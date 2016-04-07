<?php if (!defined('THINK_PATH')) exit();?><div id='Core_Rule'></div>
<div id="Core_Rule_Uploadify" style="display:none;"></div>
<script type="text/javascript">
$('#Core_Rule_Uploadify').Huploadify({
	auto:true,
	fileTypeExts:'*.data',
	multi:false,
	formData:null,
	fileSizeLimit:1024,
	showUploadedPercent:false,
	showUploadedSize:false,
	removeTimeout:1000,
	uploader:'<?php echo U("Core/imRule");?>',
	onUploadSuccess : function(file, data, response) {
		data = JSON.parse(data);
		if(!data.status){
			$.Oa.tip('提示信息', data.info,'error');
		}else{
			$.Oa.tip('提示信息', data.info,'info');
		}
	},
	'onUploadError' : function(file, errorCode, errorMsg, errorString) {
        alert(file.name + ' 上传失败。详细信息: ' + errorString);
    }
});
</script>
<script type="text/javascript">
window.Core_Rule = {
	//工具栏
	toolbar: [
		{ text: '添加', iconCls: 'icons-table-table_add', handler: function(){Core_Rule.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){Core_Rule.order();} },
		{ text: '导出', iconCls: 'icons-table-table_go', handler: function(){Core_Rule.export();} },
		{ text: '导入', iconCls: 'icons-table-table_edit', handler: function(){Core_Rule.import();} }
	],

	//排序格式化
	sort: function(val, row){
		return '<input class="sort-input-Rule" type="text" name="sort['+row['id']+']" value="'+ val +'" size="2" style="text-align:center">';
	},

	//图标格式化
	cls: function(value){
		return '<span class="oa-block tree-icon tree-file '+value+'"></span>';
	},

	//状态格式化
	status: function(value){
		if(value >= 1){//为真时
			return '<span class="oa-block tree-icon tree-file icons-arrow-accept"></span>';
		} else {
			return '<span class="oa-block tree-icon tree-file icons-other-cancel"></span>';
		}
	},

	//排序方法开始
	order: function(){
		$.messager.progress({text:'菜单排序中，请稍候...'});
		$.post("<?php echo U('Core/sortRule');?>",$(".sort-input-Rule").serialize(),function(data){
			$.messager.progress("close")
			if(!data.status){
				$.Oa.tip('提示信息', data.info,'error');
			}else{
				$.Oa.tip('提示信息', data.info,'info');
			}
		},'json').error(function(){
			$.messager.progress({text:"排序失败，请联系管理员！3秒后关闭..."});
            setTimeout('$.messager.progress("close")',3000);
		});
	},

	//导出菜单
	export: function(){
		$.messager.progress({text:'菜单导出中，请稍候...'});
		$.post("<?php echo U('Core/exRule');?>",'',function(data){
			$.messager.progress("close");
			if(!data.status){
				$.Oa.tip("提示信息", data.info,'error');
			}else{
				$.Oa.tip("提示信息", data.info,'info');
				location.href = data.url;
			}
		},'json').error(function(){
			$.messager.progress({text:"菜单导出失败，请联系管理员！3秒后关闭..."});
			setTimeout('$.messager.progress("close")',3000);
		});
	},

	//导入菜单
	import: function(){
		$.messager.confirm('提示信息', '该操作将清空所有数据，请备份好数据之后再进行导入，确定要继续吗？', function(result){
			if(!result) return false;
			$("#Core_Rule_Uploadify .uploadify-button").click();
		});
	},

	//添加菜单
	add: function(){
		var row = $('#Core_Rule').treegrid("getSelected");
		rule_id = row == null ? 0 : row.id;
		$($.Oa.dialog_1).dialog({
			title: '添加菜单',
			width: '340',
			height: '270',
			iconCls: 'icon-add',
			href: '<?php echo U("Core/addRule/");?>/rule_id/'+rule_id,
			modal: true
		});
	},

	//编辑菜单
	edit: function(id){
		if(id == null){
			var row = $('#Core_Rule').treegrid("getSelected");
			if(row == null){
				$.Oa.tip('提示信息', '请选择要处理的数据','error');
				return false;
			}
			id = row.id;
		}
		$($.Oa.dialog_1).dialog({
			title: '编辑菜单',
			width: '340',
			height: '270',
			iconCls: 'icon-edit',
			href: '<?php echo U("Core/editRule/");?>/id/'+id,
			modal: true
		});
	},

	//删除菜单
	delete: function(){
		var row = $('#Core_Rule').treegrid("getSelected");
		if(row == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		$.Oa.confirm('$.Oa.delData("'+row.id+'","<?php echo U("Core/delRule");?>")')
	}
}
</script>
<script>
/**
 * 菜单容器实例化数据
 */
$("#Core_Rule").treegrid({
	title: "系统中心 > 后台设置 > 菜单管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Rule.toolbar,
	idField: 'id',
	treeField: 'title',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Core/Rule');?>",
	/*onLoadSuccess: function () {
		$('#Core_Rule').treegrid('collapseAll')
	},*/
	columns:[[
		{field:'sort',title:'排序',align:'center',formatter:Core_Rule.sort,width:20},
		{field:'id',title:'菜单ID',align:'center',width:20},
		{field:'title',title:'菜单名称',width:200},
		{field:'name',title:'菜单规则',width:80},
		{field:'display',title:'是否显示',formatter:Core_Rule.status,width:20}
	]],
	onContextMenu: function(e, row){
		e.preventDefault(); //阻止浏览器捕获右键事件
        $(this).treegrid("unselectAll"); //取消所有选中项
        $(this).treegrid("select", row.id); //根据索引选中该行
        $('#Core_Rule_Menu').menu('show', {//显示右键菜单
            left: e.pageX,//在鼠标点击处显示菜单
            top: e.pageY
        });
	},
	onDblClickRow: function(row){
		Core_Rule.edit(row.id);
	}
});
</script>
<div id="Core_Rule_Menu" class="easyui-menu" style="display:none;">
	<div data-options="iconCls:'icon-add'" onclick="Core_Rule.add()">添加子菜单</div>
	<div data-options="iconCls:'icon-edit'" onclick="Core_Rule.edit()">修改</div>
	<div data-options="iconCls:'icon-cancel'" onclick="Core_Rule.delete()">删除</div>
</div>