<!DOCTYPE html>
<html>
<head>
	<title>Password Reset Email</title>
	<style type="text/css">
		.body{
			width: 100%;
			margin: 0 auto;
			background: #ddd;
			padding:40px 20px
		}
		
		.body .header h3{
			text-align:center;
			font-size:35px;
		}
		
		.body .content p{
			font-size:18px;
		}
		.body .content .link-btn{
			margin-top: 30px;
		}
		
		.body .content .link-btn a{
			text-decoration: none;
			text-transform: uppercase;
			background: #7952b3;
			color: #fff;
			padding: 10px 20px;
			border-radius: 2px;
		}
		
		
		.body .footer{
			margin-top:100px
		}
		.body .footer p{
			text-align:center;
		}
		
		.body .social_links{
			display: flex;
			justify-content: center;
		}
		.body .social_links a{
			text-decoration: none;
			background: #878787;
			color: #fff;
			padding: 5px 10px;
			margin-right: 2px;
			border-radius: 3px;
		}
	</style>
</head>
<body>
	<section class="body">
		<div class="header">
			<h3>{{ env("APP_NAME") }}</h3>
		</div>

		<div class="content">
			<p><b>Hi, {{ $data->name }}</b></p>
			<p style="text-align: center;">Below is your password reset link. Please click the link to reset password now. <br>Note : within 30 minutes your link will be expire. </p>
			
			<div class='link-btn' style="text-align: center;">
				<a href="{{ url('/').'/reset_passoword?email='.encrypt($email).'&token='.$token.'&userType='.encrypt($type) }}">Reset</a>
			</div>
		</div>

		<div class="footer">
			<p style="text-align: center;">{{ env("APP_NAME") }} - <?php echo date('Y');?> all rights reserved.</p>
		</div>
	</section>
</body>
</html>