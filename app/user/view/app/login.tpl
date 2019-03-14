{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
	<div class="row-fluid panels">
		<div class="pep panels">
			<div class="panel panel-default pagebox border margin">
				<div class="panel-heading bold">
					用户登陆
				</div>
				<div class="panel-body">
					<form action="index.php?user-app-login" method="post" class="regbox">
						<div class="form-group input-group">
							<span class="input-group-addon" id="basic-addon1"><a class="glyphicon glyphicon-user"></a></span>
							<input class="form-control" name="args[username]" datatype="userName" needle="needle" msg="请你输入用户名" placeholder="请输入用户名">
						</div>
						<div class="form-group input-group">
							<span class="input-group-addon" id="basic-addon1"><a class="glyphicon glyphicon-lock"></a></span>
							<input class="form-control"  name="args[userpassword]" datatype="password" needle="needle" msg="请你输入密码" placeholder="请输入密码" type="password">
						</div>
						<p class="text-right tips">
							<a class="text-warning" href="index.php?user-app-login-findpassword"> 忘记密码？</a>
						</p>
						<div class="form-group">
							<p class="text-center loginBnttonArea">
								<button type="submit" class="btn btn-primary btn-block">登陆</button>
								<input type="hidden" value="1" name="userlogin"/>
							</p>
						</div>
						<p class="text-center tips">
							<a class="text-success" href="index.php?user-app-login-register">还没有账号？立即注册</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
{x2;include:footer}
</body>
</html>