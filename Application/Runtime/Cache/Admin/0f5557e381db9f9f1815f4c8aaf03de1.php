<?php if (!defined('THINK_PATH')) exit();?><form id="addGroup" action="<?php echo U('Core/addGroup');?>" method="post">
	<input type="hidden" name="addGroup" value="addGroup" />
	<table cellspacing="6" width="100%">
		<tr>
			<td>角色名称：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[2,20]']"  name="title" type="text" style="width:220px" /></td>
		</tr>
		<tr>
			<td>角色排序：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[1,20]']"  name="sort" type="text" style="width:220px" value="50" /></td>
		</tr>
		<tr>
			<td>角色状态：</td>
			<td>
				<label><input name="status" value="1" type="radio" checked />正常</label>
				<label><input name="status" value="0" type="radio" />禁用</label>
			</td>
		</tr>
		<tr>
			<td></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="$.Oa.confirm('$.Oa.doForm(\'#addGroup\')')">添加角色</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="$($.Oa.dialog_1).dialog('close')">关闭窗口</a>
			</td>
		</tr>
	</table>
</form>