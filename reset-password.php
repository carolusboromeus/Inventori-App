<?php
	session_start();
	if( isset($_SESSION["login"]))
	{
		header("Location: dashboard.php");
		exit;
	}

	require 'functions.php';

	if (isset($_GET["key"]) && isset($_GET["id"]) && isset($_GET["action"]) && ($_GET["action"]=="reset") && !isset($_POST["action"]))
	{
		$key = $_GET["key"];
		$id = $_GET["id"];
		
		$curDate = date("Y-m-d H:i:s");
		$query = "SELECT * FROM tb_reset_token WHERE email='$id' AND token='$key'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_num_rows($result);
		
		if (!mysqli_fetch_assoc($result))
		{
			goto html;
		}
		else
		{
?>
			<html>
				<head>
					<meta charset="UTF-8">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<title>Reset Password - Admin Dashboard</title>
					<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
					<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
					<link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
					
					<link rel="stylesheet" href="assets/vendors/iconly/bold.css">

					<link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
					<link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
					<link rel="stylesheet" href="assets/css/app.css">
					<link rel="stylesheet" href="assets/css/pages/auth.css">
				</head>
				<body>
					<?php
						$query = "SELECT * FROM tb_reset_token WHERE email='$id' AND token='$key'";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_assoc($result);
						$expDate = $row['expdate'];
						if ($expDate >= $curDate)
						{
					?>
							<div id="auth">
								<div class="row h-100">
									<div class="col-lg-5 col-12">
										<div id="auth-left">
											<div class="auth-logo">
												<a href="index.php"><img src="assets/images/logo/logo.png" alt="Logo"></a>
											</div>
											<h1 class="auth-title">Reset Password</h1>
											<p class="auth-subtitle mb-5">Input your new password and retype new password.</p>

											<?php if(isset($error) ):?>
												<p style="color:red;">Password tidak sama</p>
											<?php endif; ?>
											<form action="" method="post" name="update">
												<input type="hidden" class="form-control form-control-xl" name="email" value="<?=$id?>" readonly>
												<div class="form-group position-relative has-icon-left mb-4">
													<input type="password" id="new password" class="form-control form-control-xl" name="new_password" placeholder="New Password" autocomplete="off" required>
													<div class="form-control-icon">
														<i class="bi bi-shield-lock"></i>
													</div>
												</div>
												<div class="form-group position-relative has-icon-left mb-4">
													<input type="password" id="confirm password" class="form-control form-control-xl" name="confirm_password" placeholder="Retype Password" autocomplete="off" required>
													<div class="form-control-icon">
														<i class="bi bi-shield-lock"></i>
													</div>
												</div>
												<button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit" name="update">Submit</button>
												<?php

													if(isset($_POST["update"]))
													{
														// cek apakah data berhasil di ubah atau tidak
														if(change_password($_POST) > 0)
														{
															echo "
																<script>
																	alert('Password berhasil diubah!');
																	document.location.href = 'index.php';
																</script>
															";
														}
														else
														{
															$error = true;
														}
													}
												?>
											</form>
										</div>
									</div>
									<div class="col-lg-7 d-none d-lg-block">
										<div id="auth-right">

										</div>
									</div>
								</div>
							</div>
					<?php
						}
						else
						{
							html:
					?>	
							<head>
								<meta charset="UTF-8">
								<meta name="viewport" content="width=device-width, initial-scale=1.0">
								<title>Reset Password - Admin Dashboard</title>
								<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
								<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
								<link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
								
								<link rel="stylesheet" href="assets/vendors/iconly/bold.css">

								<link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
								<link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
								<link rel="stylesheet" href="assets/css/app.css">
								<link rel="stylesheet" href="assets/css/pages/auth.css">
							</head>
							<div id="auth">
								<div class="row h-100">
									<div class="col-lg-5 col-12">
										<div id="auth-left">
											<div class="auth-logo">
												<a href="index.php"><img src="assets/images/logo/logo.png" alt="Logo"></a>
											</div>
											<h1 class="auth-title">Reset Password</h1>
											<p class="auth-subtitle mb-5">
												The link is invalid/expired. Either you did not copy the correct link
												from the email, or you have already used the key in which case it is 
												deactivated.
											</p>
											<div class="mt-5 text-lg fs-4">
												<p class="text-gray-600">Please to forgot password on 
													<a href="https://localhost/inventori/auth-forgot-password.php" class="font-bold">click here</a>.
												</p>
											</div>
										</div>
									</div>
									<div class="col-lg-7 d-none d-lg-block">
										<div id="auth-right">

										</div>
									</div>
								</div>
							</div>
					<?php
						}
					?>
				</body>
			</html>
<?php
		}		
	} // isset email key validate end
?>
