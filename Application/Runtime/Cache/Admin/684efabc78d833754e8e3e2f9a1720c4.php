<?php if (!defined('THINK_PATH')) exit();?><form id="editJob" action="<?php echo U('Core/editJob');?>" method="post">
	<input type="hidden" name="id" value="<?php echo ($Job["id"]); ?>" />
	<input type="hidden" name="editJob" value="editJob" />
	<table cellspacing="6" width="100%">
		<tr>
			<td>职务名称：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[2,20]']"  name="title" type="text" style="width:220px" value="<?php echo ($Job["title"]); ?>" /></td>
		</tr>
		<tr>
			<td>职务排序：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[1,20]']"  name="sort" type="text" style="width:220px" value="<?php echo ($Job["sort"]); ?>" /></td>
		</tr>
		<tr>
			<td></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-edit'" onclick="$.Oa.confirm('$.Oa.doForm(\'#editJob\')')">编辑职务</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="$($.Oa.dialog_1).dialog('close')">关闭窗口</a>
			</td>
		</tr>
	</table>
</form>