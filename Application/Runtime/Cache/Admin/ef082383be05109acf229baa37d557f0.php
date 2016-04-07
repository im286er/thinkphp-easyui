<?php if (!defined('THINK_PATH')) exit();?><form id="addRule" action="<?php echo U('Core/addRule');?>" method="post">
	<input type="hidden" name="addRule" value="addRule" />
	<table cellspacing="6" width="100%">
		<tr>
			<td width="60">上级菜单：</td>
			<td><input class="easyui-combotree" data-options="url:'<?php echo U('CoreCommon/treeRule');?>'" name="rule_id" value="<?php echo ($rule_id); ?>" style="width:230px;height:24px" /></td>
		</tr>
		<tr>
			<td>菜单名称：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[2,20]']"  name="title" type="text" style="width:220px" /></td>
		</tr>
		<tr>
			<td>菜单规则：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[2,40]','remote[\'<?php echo U('CoreCommon/checkAddRule');?>\',\'name\']']" name="name" type="text" style="width:220px" /></td>
		</tr>
		<tr>
			<td>菜单排序：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[1,20]']"  name="sort" type="text" style="width:220px" value="50" /></td>
		</tr>
		<tr>
			<td>菜单图标：</td>
			<td>
				<input id="Core_Rule_icons_input" name="cls" type="hidden" value="icons-other-cog" />
				<strong id="Core_Rule_icons"><span class="tree-icon tree-file icons-other-cog"></span></strong>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="Show_Core_Rule_icons()">选择图标</a>
			</td>
		</tr>
		<tr>
			<td>是否显示：</td>
			<td>
				<label><input name="display" value="1" type="radio" checked />是</label>
				<label><input name="display" value="0" type="radio" />否</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="$.Oa.confirm('$.Oa.doForm(\'#addRule\')')">添加菜单</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="$($.Oa.dialog_1).dialog('close')">关闭窗口</a>
			</td>
		</tr>
	</table>
</form>
<script>
function Select_Core_Rule_icons(cls){
	$("#Core_Rule_icons").html('<span class="tree-icon tree-file '+cls+'"></span>');
	$("#Core_Rule_icons_input").val(cls);
	$($.Oa.dialog_2).dialog("close");
}
function Show_Core_Rule_icons(){
	$($.Oa.dialog_2).dialog({
		title: "选择图标",
		width: '387',
		height: '300',
		left: $("#Core_Rule_icons").offset().left+100+"px",
		top: "230px",
		content: $.Oa.loading("正在加载图标中..."),
		modal: true
	});
	$.post("<?php echo U('CoreCommon/iconsCls');?>","",function(data){
		if(typeof data == 'object'){
			var content = [];
			for(x in data){
				content[x] = "<span class='tree-icon tree-file "+data[x]+"' onclick=\"Select_Core_Rule_icons('"+data[x]+"')\" style='cursor:pointer;'></span>";
			}
			$($.Oa.dialog_2).dialog({content: "<div style='padding:10px;'>"+content.join(" ")+"</div>"});
		} else {
			$($.Oa.dialog_2).dialog({content: "<div style='padding:10px;'>图标加载失败，请联系管理员！</div>"});
		}
	},'json').error(function(){
		$.messager.progress({text:"读取图标信息失败，请联系管理员，3秒后自动关闭..."});
		setTimeout("$.messager.progress('close')",3000);
	});

}
</script>