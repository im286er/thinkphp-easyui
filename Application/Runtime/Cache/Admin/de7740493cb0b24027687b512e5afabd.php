<?php if (!defined('THINK_PATH')) exit();?><form id="editPanel" action="<?php echo U('Panel/editPanel');?>" method="post">
	<input type="hidden" name="editPanel" value="editPanel" />
	<input type="hidden" name="id" value="<?php echo ($Panel["id"]); ?>" />
	<table width="100%">
		<tr>
			<td>版块名称：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[2,20]']"  name="title" type="text" style="width:220px" value="<?php echo ($Panel["title"]); ?>" /></td>
		</tr>
		<tr>
			<td>版块排序：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[1,20]']"  name="sort" type="text" style="width:220px" value="<?php echo ($Panel["sort"]); ?>" /></td>
		</tr>
		<tr>
			<td>版块内容：</td>
			<td>
				<textarea style="display:none;" name="content" id="Panel_content"><?php echo ($Panel["content"]); ?></textarea>
				<?php echo getUEditor("Panel_UEditor","680","210");?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onclick="editPanel()">编辑版块</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="$($.Oa.dialog_1).dialog('close')">关闭窗口</a>
			</td>
		</tr>
	</table>
</form>
<script>
Panel_UEditor.ready(function(){
    UE.getEditor("Panel_UEditor").setContent($("#Panel_content").val());
});
function editPanel(){
	$("#Panel_content").val(UE.getEditor('Panel_UEditor').getContent());
	$.Oa.confirm('$.Oa.doForm(\'#editPanel\')');
}
</script>