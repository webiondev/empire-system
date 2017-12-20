<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Education Oasis - Login</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="base_url" content="<% URL::to('/') %>">
	<meta name="_token" content="<% csrf_token() %>"/>
	<meta name="csrf-token" content="<% csrf_token() %>" />

	<link rel="stylesheet" type="text/css" href="<% URL::asset('assets/css/reset.css') %>">
	<link rel="stylesheet" type="text/css" href="<% URL::asset('assets/css/structure.css') %>">
	
	<link rel="stylesheet" type="text/css" href="<% URL::asset('assets/css/font-awesome.min.css') %>">
</head>

<body class="login_bg">
<div class="form_total">
<div align="center" class="logo">
 <img src="<% URL::asset('assets/img/logo_Oasis.png') %>" width="100" width="100" style="margin:20px 0 10px 0px;"/> </div>

 	<div class="panel-body lgn_bdy">
	            <span class="help-block">
	                <strong class="lgn_error" style="color:red">You are locked. Please contact admin</strong>
	            </span>
	        </div>

</div>

<footer id="main">
  <a href="#">Education Oasis</a> | 2017
</footer>

</body>
</html>