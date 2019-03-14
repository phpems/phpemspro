{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid">
		<div class="pep">
			<div class="panel panel-default regbox">
				<div class="panel-heading">用户登录</div>
				<div class="panel-body">
					<form method="post" action="index.php?core-master-login" class="form-horizontal col-xs-12">
						<div class="form-group">
							<label for="fieldtitle" class="control-label">用户名</label>
							<div class="controls">
								<input type="text" class="form-control" size="40" name="args[username]" needle="needle" datatype="userName" msg="您必须填写字段别名，字段别名必须为中英文字符或数字"/>
							</div>
						</div>
						<div class="form-group">
							<label for="fieldtitle" class="control-label">密码</label>
							<div class="controls">
								<input type="password" class="form-control" size="40" name="args[userpassword]" needle="needle" datatype="password" msg="您必须填写字段别名，字段别名必须为中英文字符或数字"/>
							</div>
						</div>
						<div class="form-group">
							<div class="controls">
								<label class="checkbox-inline">
									<input type="checkbox" name="savepassword" value="1"/> 记住密码
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="controls">
								<input type="hidden" name="userlogin" value="1"/>
								<button class="btn btn-primary btn-block" type="submit">登录</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>