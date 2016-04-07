<?php if (!defined('THINK_PATH')) exit();?><div id='Core_Branch'></div>
<script type="text/javascript">
window.Core_Branch = {
	//工具栏
	toolbar: [
		{ text: '添加', iconCls: 'icons-table-table_add', handler: function(){Core_Branch.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){Core_Branch.order();} },
	],

	//排序格式化
	sort: function(val, row){
		return '<input class="sort-input-Branch" type="text" name="sort['+row['id']+']" value="'+ val +'" size="2" style="text-align:center">';
	},

	//排序方法开始
	order: function(){
		$.messager.progress({text:'部门排序中，请稍候...'});
		$.post("<?php echo U('Branch/sortBranch');?>",$(".sort-input-Branch").serialize(),function(data){
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

	//添加部门
	add: function(){
		var row = $('#Core_Branch').treegrid("getSelected");
		branch_id = row == null ? 0 : row.id;
		$($.Oa.dialog_1).dialog({
			title: '添加部门',
			width: '330',
			height: '181',
			iconCls: 'icon-add',
			href: '<?php echo U("Branch/addBranch/");?>/branch_id/'+branch_id,
			modal: true
		});
	},

	//编辑部门
	edit: function(id){
		if(id == null){
			var row = $('#Core_Branch').treegrid("getSelected");
			if(row == null){
				$.Oa.tip('提示信息', '请选择要处理的数据','error');
				return false;
			}
			id = row.id;
		}
		$($.Oa.dialog_1).dialog({
			title: '编辑部门',
			width: '330',
			height: '181',
			iconCls: 'icon-edit',
			href: '<?php echo U("Branch/editBranch/");?>/id/'+id,
			modal: true
		});
	},

	//删除部门
	delete: function(){
		var row = $('#Core_Branch').treegrid("getSelected");
		if(row == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		id = row.id;
		$.Oa.confirm('$.Oa.delData("'+id+'","<?php echo U("Branch/delBranch");?>")')
	}
}
</script>
<script>
/**
 * 部门容器实例化数据
 */
$("#Core_Branch").treegrid({
	title: "系统中心 > 用户设置 > 部门管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Branch.toolbar,
	idField: 'id',
	treeField: 'title',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Branch/index');?>",
	columns:[[
		{field:'sort',title:'排序',align:'center',formatter:Core_Branch.sort,width:20},
		{field:'id',title:'ID',align:'center',width:20},
		{field:'title',title:'部门名称',width:300},
	]],
	onContextMenu: function(e, row){
		e.preventDefault(); //阻止浏览器捕获右键事件
        $(this).treegrid("unselectAll"); //取消所有选中项
        $(this).treegrid("select", row.id); //根据索引选中该行
        $('#Core_Branch_Menu').menu('show', {//显示右键部门
            left: e.pageX,//在鼠标点击处显示部门
            top: e.pageY
        });
	},
	onDblClickRow: function(row){
		Core_Branch.edit(row.id);
	}
});
</script>
<div id="Core_Branch_Menu" class="easyui-menu" style="display:none;">
	<div data-options="iconCls:'icon-add'" onclick="Core_Branch.add()">添加子部门</div>
	<div data-options="iconCls:'icon-edit'" onclick="Core_Branch.edit()">修改</div>
	<div data-options="iconCls:'icon-cancel'" onclick="Core_Branch.delete()">删除</div>
</div>