<?php

	// if user has the correct hash,
	// or has no password set, we log in automatically
	if($_GET['hash'] == $serverini['hash'] || $serverini['hash'] == '')
	{
		echo 'Password is valid!';
		$_SESSION['signedin'] = 'true';

		header("Location: ?page=dashboard");
	}

	// check password
	if($_POST['login'] == 'true')
	{
		if($_POST['password'] != '')
		{
			if (password_verify($_POST['password'], $serverini['hash']))
			{
				echo 'Password is valid!';
				$_SESSION['signedin'] = 'true';

				header('Location: ?page='.$serverini['lastpage'].
									'&content='.$serverini['lastcontent'].
									'&id='.$serverini['lastid']);
			}
			else
			{
				echo 'Invalid password.';
			}
		}
	}

?>

<div class="container">
    <div class="pagination-centered">
		<h3>Login</h3>

		<form action="" method="post">
			<input type="password" name="password" /><br><br>

			<button type='submit' name='login' value='true' class='btn btn-success'>
				<i class='fa fa-check-square' aria-hidden='true'></i> Log In
			</button>
		</form>
	</div>
</div>


