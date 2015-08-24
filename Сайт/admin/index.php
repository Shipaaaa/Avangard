<?php
session_start ();

if (!empty ($_SESSION['admin']))
{
if ($_SESSION['admin'])
{
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Административная панель</title>
		<style type="text/css">
		#wrap
		{
		width: 100%;
		height: 100%;
		}
		.loginbox1
		{
		width: 300px;
		padding: 4px;
		border: 1px solid #777;
		background-color: #777;
		color: white;
		font-weight: bold;
		}
		.loginbox2
		{
		width: 300px;
		padding: 4px;
		border: 1px solid #777;
		color: #777;
		}
		</style>
	</head>
	<body>
		<center>
			<table cellpadding="0" cellspacing="0" id="wrap"><tr><td align="center">
				<table cellpadding="0" cellspacing="0">
					<tr><td class="loginbox1" align="center">Вход выполнен</td></tr>
					<tr><td class="loginbox2" align="center"><a href="admin_main.php">Перейти к административной панели</a></td></tr>
					<tr><td class="loginbox2" align="center"><a href="admin_logout.php">Выйти</a></td></tr>
				</table>
			</td>
			</tr>
			</table>
		</center>
	</body>
</html>
<?
exit;
}
}

$_SESSION['admin'] = false;
include ('config.php');

function not_logged_in ()
{
echo'
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Административная панель</title>
<style type="text/css">
#wrap
{
width: 100%;
height: 100%;
}
#wraptd
{
padding: 20px;
}
.loginbox1
{
width: 300px;
padding: 4px;
border: 1px solid #777;
background-color: #777;
color: white;
font-weight: bold;
}
.loginbox2
{
width: 300px;
padding: 4px;
border: 1px solid #777;
color: #777;
}
.loginbox2 input
{
width: 200px;
margin: 3px 0;
border-color: #888;
color: #777;
}
</style>
</head>
<body>
	<center>
		<table cellpadding="0" cellspacing="0" id="wrap"><tr><td align="center" id="wraptd">
			<table cellpadding="0" cellspacing="0">
				<tr><td class="loginbox1" align="center">Вход в административную панель</td></tr>
				<tr><td class="loginbox2" align="center">
				<form action="index.php" method="post">
				<input required type="text" name="login" value="" placeholder="Введите логин"><br>
				<input required type="password" name="password" value="" placeholder="Введите пароль"><br>
				<input type="submit" value="Войти">
			</form>
			</td></tr>
			</table>
		</td>
		</tr>
		</table>
	</center>
</body>
</html>';
exit;
}

if (!$_POST) not_logged_in ();
if (!$_POST['login']) not_logged_in ();
if (!$_POST['password']) not_logged_in ();
if ($_POST['login']!= $adminlogin)  { echo "<script>alert(\"Неправильный логин или пароль.\");</script>"; not_logged_in ();}
if ($_POST['password']!= $adminpassw) { echo "<script>alert(\"Неправильный логин или пароль.\");</script>"; not_logged_in ();}
$_SESSION['admin'] = true;
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Административная панель</title>
		<style type="text/css">
		#wrap
		{
		width: 100%;
		height: 100%;
		}
		.loginbox1
		{
		width: 300px;
		padding: 4px;
		border: 1px solid #777;
		background-color: #777;
		color: white;
		font-weight: bold;
		}
		.loginbox2
		{
		width: 300px;
		padding: 4px;
		border: 1px solid #777;
		color: #777;
		}
		</style>
	</head>
	<body>
		<center>
			<table cellpadding="0" cellspacing="0" id="wrap"><tr><td align="center">
				<table cellpadding="0" cellspacing="0">
					<tr><td class="loginbox1" align="center">Вход выполнен</td></tr>
					<tr><td class="loginbox2" align="center"><a href="admin_main.php">Перейти к административной панели</a></td></tr>
					<tr><td class="loginbox2" align="center"><a href="admin_logout.php">Выйти</a></td></tr>
				</table>
			</td>
			</tr>
			</table>
		</center>
	</body>
</html>