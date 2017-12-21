<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  </head>
  <body>

  @include('header')

		<div class="container-fluid">
			<div class="col-xs-12 col-sm-12 col-md-12">
					<center><h1>Plateforme de Recensement des Ecoles!</h1></center>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<?php
							if (isset($message_display)) 
							{
							echo "<br><br><center><div class='message'><h4>";

							echo $message_display;

							echo "</h4></div></center><br>";
							}
							else
							{
								echo "<br><br>";
							}
						?>
					</div>
					<br>
					<div class="col-xs-12 col-sm-12 col-md-12">
						<form action = "lolo" method = "post">
							{{ csrf_field() }}
							<div class="col-xs-6 col-sm-6 col-md-6" style=" position:absolute; top:50%; left:25%; width: 50%">
								<div class="list-group-item">
									<input type="text" placeholder="Nom Utilisateur" class="form-control no-border" id="email" name="email">
								</div>
								<div class="list-group-item">
									<input type="password" placeholder="Mot de passe" class="form-control no-border" id="password" name="password">
								</div>
								<br>
								<button type="submit" name="submit" id="submit" value="submit" class="btn btn-lg btn-primary btn-block">Connexion</button>
							</div>
						</form>
					</div>	
			</div>
		</div>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>