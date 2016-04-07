<?php if (!defined('THINK_PATH')) exit();?><form id="addUser" action="<?php echo U('Core/addUser');?>" method="post">
	<input type="hidden" name="addUser" value="addUser" />
	<table cellspacing="6" width="100%">
		<tr>
			<td>登录账号：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['name','length[2,20]']"  name="name" type="text" style="width:160px" /></td>
			<td>用户昵称：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['title','length[2,20]']"  name="title" type="text" style="width:160px" /></td>

		</tr>
		<tr>
			<td>登录密码：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['length[6,20]']"  name="pass" type="password" id="password" style="width:160px" /></td>
			<td>确认密码：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['password[\'#password\']','length[6,20]']"  name="pass2" type="password" style="width:160px" /></td>
		</tr>
		<tr>
			<td>所属部门：</td>
			<td><input class="easyui-combobox" data-options="valueField: 'id',required:true,textField: 'title',url: '<?php echo U('CoreCommon/listBranch');?>'"  name="branch_id" style="width:170px" /></td>
			<td>工作职务：</td>
			<td><input class="easyui-combobox" data-options="valueField: 'id',required:true,textField: 'title',url: '<?php echo U('CoreCommon/listJob');?>'"  name="job_id" style="width:170px" /></td>
		</tr>
		<tr>
			<td>用户状态：</td>
			<td>
				<input name="status" type='radio' id="status1" value="1" checked /> <label for="status1">正常</label>
				<input name="status" type='radio' id="status0" value="0" /> <label for="status0">禁用</label>
			</td>
			<td>回访权限：</td>
			<td>
				<input name="visit" type='radio' id="visit1" value="1" /> <label for="visit1">可回访</label>
				<input name="visit" type='radio' id="visit0" value="0" checked /> <label for="visit0">禁回访</label>
			</td>
		</tr>
		<tr>
			<td>数据级别：</td>
			<td>
				<input name="data_level" type='radio' id="data_level1" value="1" /> <label for="data_level1">管理</label>
				<input name="data_level" type='radio' id="data_level0" value="0" checked /> <label for="data_level0">普通</label>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>所属角色：</td>
			<td><input class="easyui-combobox" data-options="valueField: 'id',required:true,textField: 'title',multiple:true,url: '<?php echo U('CoreCommon/listGroup');?>'"  name="groups[][uid]" style="width:170px" /></td>
        </tr>
		<tr>
			<td>手机号码：</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['phone','length[2,20]']"  name="phone" type="text" style="width:160px" /></td>
			<td>QQ号码:</td>
			<td><input class="easyui-textbox" data-options="required:true,validType:['qq']"  name="qq" type="text" style="width:160px" /></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td align="right">
				<a class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="$.Oa.confirm('$.Oa.doForm(\'#addUser\')')">添加用户</a>
				<a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="$($.Oa.dialog_1).dialog('close')">关闭窗口</a>
			</td>
		</tr>
	</table>
</form>