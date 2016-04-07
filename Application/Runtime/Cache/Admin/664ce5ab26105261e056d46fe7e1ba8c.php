<?php if (!defined('THINK_PATH')) exit();?><table id="Core_Panel"></table>
<script type="text/javascript">
window.Core_Panel = {
	//工具栏
	toolbar: [
		{ text: '添加', iconCls: 'icons-table-table_add', handler: function(){Core_Panel.add();} },
		{ text: '刷新', iconCls: 'icons-table-table_refresh', handler: function(){$.Oa.refresh();} },
		{ text: '排序', iconCls: 'icons-table-table_sort', handler: function(){Core_Panel.order();} }
	],

	//排序格式化
	sort: function(val, row){
		return '<input class="sort-input-Panel" type="text" name="sort['+row['id']+']" value="'+ val +'" size="2" style="text-align:center">';
	},

	//操作格式化
	opert: function(value){
		return '<a href="javascript:void(0)" onclick="Core_Panel.edit('+value+')">修改</a> | <a href="javascript:void(0)" onclick="Core_Panel.delete('+value+')">删除</a>';
	},

	//排序方法开始
	order: function(){
		$.messager.progress({text:'版块排序中，请稍候...'});
		$.post("<?php echo U('Panel/sortPanel');?>",$(".sort-input-Panel").serialize(),function(data){
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

	//添加版块
	add: function(){
		$($.Oa.dialog_1).dialog({
			title: '添加版块',
			width: '800',
			height: '480',
			top: '10%',
			left :'20%',
			iconCls: 'icon-add',
			href: '<?php echo U("Panel/addPanel");?>',
			modal: true
		});
	},

	//编辑版块
	edit: function(id){
		if(id == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		$($.Oa.dialog_1).dialog({
			title: '编辑版块',
			width: '800',
			height: '480',
			top: '10%',
			left :'20%',
			iconCls: 'icon-edit',
			href: '<?php echo U("Panel/editPanel/");?>/id/'+id,
			modal: true
		});
	},

	//删除版块
	delete: function(id){
		if(id == null){
			$.Oa.tip('提示信息', '请选择要处理的数据','error');
			return false;
		}
		$.Oa.confirm('$.Oa.delData("'+id+'","<?php echo U("Panel/delPanel");?>")')
	}
}
</script>
<script>
/**
 * 版块容器实例化数据
 */
$("#Core_Panel").datagrid({
	title: "系统中心 > 后台设置 > 版块管理",
	singleSelect:true,
	nowrap:true,
	border: false,
	fitColumns: true,
	fit: true,
	toolbar: Core_Panel.toolbar,
	idField: 'id',
	rownumbers: true,
	animate: true,
	url: "<?php echo U('Panel/index');?>",
	columns:[[
		{field:'sort',title:'排序',align:'center',formatter:Core_Panel.sort,width:30},
		{field:'id',title:'版块ID',align:'center',width:20},
		{field:'title',title:'版块名称',width:200},
		{field:'opert_id',title:'操作',formatter:Core_Panel.opert,width:100}
	]],
	pagination:true,
	pagePosition:'bottom',
	pageNumber:1,
	pageSize:20,
	pageList:[20,30,50],
	onDblClickRow: function(rowIndex,rowData){
		Core_Panel.edit(rowData.id);
	}
});
</script>