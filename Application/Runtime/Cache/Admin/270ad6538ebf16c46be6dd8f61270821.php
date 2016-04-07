<?php if (!defined('THINK_PATH')) exit();?><table id="Core_Group"></table>
<script type="text/javascript">
window.Core_Group = {
	//工具栏
	toolbar: [
		{ text: '添加', iconCls: 'icons-table-table_add', handler: function(){Core_Group.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){Core_Group.order();} }
	],

	//排序格式化
	sort: function(val, row){
		return '<input class="sort-input-Group" type="text" name="sort['+row['id']+']" value="'+ val +'" size="2" style="text-align:center">';
	},

	//状态格式化
	status: function(value){
		if(value >= 1){//为真时
			return '<span class="oa-block tree-icon tree-file icons-arrow-accept"></span>';
		} else {
			return '<span class="oa-block tree-icon tree-file icons-other-cancel"></span>';
		}
	},

	//操作格式化
	opert: function(value){
		if(value == '1'){
			return '权限配置 | 修改 | 删除';
		} else {
			return '<a href="javascript:void(0)" onClick="Core_Group.set('+value+')">权限配置</a> | <a href="javascript:void(0)" onclick="Core_Group.edit('+value+')">修改</a> | <a href="javascript:void(0)" onclick="Core_Group.delete('+value+')">删除</a>';
		}
	},

	//排序方法开始
	order: function(){
		$.messager.progress({text:'角色排序中，请稍候...'});
		$.post("<?php echo U('Core/sortGroup');?>",$(".sort-input-Group").serialize(),function(data){
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

	//添加角色
	add: function(){
		$($.Oa.dialog_1).dialog({
			title: '添加角色',
			width: '330',
			height: '180',
			iconCls: 'icon-add',
			href: '<?php echo U("Core/addGroup/");?>',
			modal: true
		});
	},

	//角色权限配置
	set: function(id){
		if(id == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		if(id == '1'){
			$.Oa.tip('提示信息', '不允许对超级管理员进行编辑','error');
			return false;
		}
		id = id;
		$($.Oa.dialog_1).dialog({
			title: '权限配置',
			width: '320',
			height: '200',
			iconCls: 'icon-edit',
			href: '<?php echo U("Core/setGroup/");?>/id/'+id,
			modal: true,
			method: 'get'
		});
	},

	//编辑角色
	edit: function(id){
		if(id == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		if(id == '1'){
			$.Oa.tip('提示信息', '不允许对超级管理员进行编辑','error');
			return false;
		}
		$($.Oa.dialog_1).dialog({
			title: '编辑角色',
			width: '330',
			height: '180',
			iconCls: 'icon-edit',
			href: '<?php echo U("Core/editGroup/");?>/id/'+id,
			modal: true
		});
	},

	//删除角色
	delete: function(id){
		if(id == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		if(id == '1'){
			$.Oa.tip('提示信息', '不允许对超级管理员进行编辑','error');
			return false;
		}
		$.Oa.confirm('$.Oa.delData("'+id+'","<?php echo U("Core/delGroup");?>")')
	}
}
</script>
<script>
/**
 * 角色容器实例化数据
 */
$("#Core_Group").datagrid({
	title: "系统中心 > 用户设置 > 角色管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Group.toolbar,
	idField: 'id',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Core/Group');?>",
	columns:[[
		{field:'sort',title:'排序',align:'center',formatter:Core_Group.sort,width:30},
		{field:'id',title:'角色ID',align:'center',width:20},
		{field:'title',title:'角色名称',width:200},
		{field:'status',title:'角色状态',formatter:Core_Group.status,width:20},
		{field:'opert_id',title:'操作',formatter:Core_Group.opert,width:100}
	]],
	pagination:true,
	pagePosition:'bottom',
	pageNumber:1,
	pageSize:20,
	pageList:[20,30,50],
	onDblClickRow: function(rowIndex,rowData){
		Core_Group.edit(rowData.id);
	}
});
</script>