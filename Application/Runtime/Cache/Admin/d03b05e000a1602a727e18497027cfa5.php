<?php if (!defined('THINK_PATH')) exit();?><table id="Core_Job"></table>
<script type="text/javascript">
window.Core_Job = {
	//工具栏
	toolbar: [
		{ text: '添加', iconCls: 'icons-table-table_add', handler: function(){Core_Job.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){Core_Job.order();} }
	],

	//排序格式化
	sort: function(val, row){
		return '<input class="sort-input-Job" type="text" name="sort['+row['id']+']" value="'+ val +'" size="2" style="text-align:center">';
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
		$.messager.progress({text:'职务排序中，请稍候...'});
		$.post("<?php echo U('Job/sortJob');?>",$(".sort-input-Job").serialize(),function(data){
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

	//添加职务
	add: function(){
		$($.Oa.dialog_1).dialog({
			title: '添加职务',
			width: '330',
			height: '150',
			iconCls: 'icon-add',
			href: '<?php echo U("Job/addJob/");?>',
			modal: true
		});
	},

	//编辑职务
	edit: function(id){
		if(id == null){
			var row = $('#Core_Job').datagrid("getSelected");
			if(row == null){
				$.Oa.tip('提示信息', '请选择要处理的数据','error');
				return false;
			}
			id = row.id;
		}
		if(id == '1'){
			$.Oa.tip('提示信息', '不允许对超级管理员进行编辑','error');
			return false;
		}
		$($.Oa.dialog_1).dialog({
			title: '编辑职务',
			width: '330',
			height: '150',
			iconCls: 'icon-edit',
			href: '<?php echo U("Job/editJob/");?>/id/'+id,
			modal: true
		});
	},

	//删除职务
	delete: function(id){
		if(id == null){
			var row = $('#Core_Job').datagrid("getSelected");
			if(row == null){
				$.Oa.tip('提示信息', '请选择要处理的数据','error');
				return false;
			}
			id = row.id;
		}
		if(id == '1'){
			$.Oa.tip('提示信息', '不允许对超级管理员进行编辑','error');
			return false;
		}
		$.Oa.confirm('$.Oa.delData("'+id+'","<?php echo U("Job/delJob");?>")')
	}
}
</script>
<script>
/**
 * 职务容器实例化数据
 */
$("#Core_Job").datagrid({
	title: "系统中心 > 用户设置 > 职务管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Job.toolbar,
	idField: 'id',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Job/index');?>",
	columns:[[
		{field:'sort',title:'排序',align:'center',formatter:Core_Job.sort,width:30},
		{field:'id',title:'职务ID',align:'center',width:20},
		{field:'title',title:'职务名称',width:400},
	]],
	pagination:true,
	pagePosition:'bottom',
	pageNumber:1,
	pageSize:20,
	pageList:[20,30,50],
	onDblClickRow: function(rowIndex,rowData){
		Core_Job.edit(rowData.id);
	},
	onRowContextMenu: function(e, rowIndex,rowData){
		e.preventDefault(); //阻止浏览器捕获右键事件
        $(this).datagrid("unselectAll"); //取消所有选中项
        $(this).datagrid("selectRow",rowIndex); //根据索引选中该行
        $('#Core_Job_Menu').menu('show', {//显示右键部门
            left: e.pageX,//在鼠标点击处显示部门
            top: e.pageY
        });
	}
});
</script>
<div id="Core_Job_Menu" class="easyui-menu" style="display:none;">
	<div data-options="iconCls:'icon-edit'" onclick="Core_Job.edit()">修改</div>
	<div data-options="iconCls:'icon-cancel'" onclick="Core_Job.delete()">删除</div>
</div>