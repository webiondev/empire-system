
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
<form class="box login form_total_inner" method="post" action="<% url('/login') %>">
	
	<input type="hidden" name="_token" value="<% csrf_token() %>">
	
	<fieldset class="boxBody">
	<div class="boxBody_inner">
	  <!--<label>Username </label>-->
	  <label><i class="fa fa-user" aria-hidden="true"></i><!--Username--></label>
	  <input name="email" type="text" tabindex="1" placeholder="University ID" required> </div>
	  <div class="boxBody_inner"><label><i class="fa fa-unlock" aria-hidden="true" ></i><!--Password--></label>
	  <!--<label><a href="#" placeholder="Password"  class="rLink" tabindex="5">Forget your password?</a>Password</label> -->
	  <input name="password"  placeholder="Password" type="password" tabindex="2" required></div>
	<!--<a href="#" class="rLink" tabindex="5">Forget your password?</a>-->
	</fieldset>

	<fieldset>

		 @if (session('warning'))
		 <div class="panel-body lgn_bdy">
	            <span class="help-block">
	                <strong class="lgn_error"><% session('warning')  %></strong>
	                
	            </span>
	        </div>
		@endif

	 
	  	@if($errors->has('password'))
	  	<div class="panel-body lgn_bdy">
	            <span class="help-block">
	                <strong class="lgn_error"><% $errors->first('password')  %></strong>
	                
	            </span>
	        </div>
	        @endif
	    

	  	@if($errors->has('email'))
	  	<div class="panel-body lgn_bdy">
	            <span class="help-block">
	                <strong class="lgn_error"><% $errors->first('email') %> Or your password has been locked. Contact admin</strong>
	                
	            </span>
	        </div>
	        @endif

		
	</fieldset>

	<footer>
	  <label><input type="checkbox" tabindex="3">Keep me logged in</label>
	  <center><input type="submit" class="btnLogin" value="Login" tabindex="4"></center>
	</footer>


</form>
</div>

<footer id="main">
  <a href="#">Education Oasis</a> | 2017
</footer>

</body>
</html>