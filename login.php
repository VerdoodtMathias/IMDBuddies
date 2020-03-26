<?php

	function canLogin($email, $password) {
		$conn = new mysqli("localhost", "root", "root", "IMDBuddies");
		$email = $conn->real_escape_string($email);
		$sql = "select * from users where email = '$email'";
		$result = $conn->query($sql);

		if($result->num_rows != 1){
			return false;
		}

		$user = $result->fetch_assoc();
		$hash = $user['password'];
		if(password_verify($password, $hash)){
			return true;
		} else {
			return false;
		}
	}

	// if form was submit
	if( !empty($_POST) ) {
		// check if required fields are not empty
		$email = $_POST['email'];
		$password = $_POST['password'];
		if( !empty($email) && !empty($password) ) {
			// check if username = "net" password = "flix"
			if(canLogin($email, $password)){
				// set cookie
				session_start();
				$_SESSION["user"] = $email;
				
				// redirect to index.php
				header('Location: index.php');
			}
			else {
				// user+pass don't match
				// show error
				$error = "Cannot log you in.";
			}
			
		} else {
			$error = "Username and password are required.";
		}
		
	}


?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log in to Companion</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="companionLogin">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign In</h2>

				<?php if(isset($error)) : ?>
				<div class="form__error">
					<p>
						<?php echo $error; ?>
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="Email">Email</label>
					<input type="text" id="Email" name="email">
				</div>
				<div class="form__field">
					<label for="Password">Password</label>
					<input type="password" id="Password" name="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
				</div>
			</form>
		</div>
	</div>
</body>
</html>