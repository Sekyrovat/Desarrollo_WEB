<!-- I had trouble using php in my computer, as it was not installed. Therefore I can't assure although I think it works. I left the action in the login form as to take the user to a mockup home page, if you want to try the php, please take out the action from the form. As of now only the login button works, but due to a lack of DB there is no need for user and pass -->
<?php
	if (isset($_POST["registerButton"])) {
	    header("Location: index.php");
	}
	if (isset($_POST["forgot"])) {
		header("Location: index.php");
	}
	if (isset($_POST["loginButton"])) {
	    header("Location: html/homePage.html");
	}
?>

<!DOCTYPE html>
<html>
	<body>

		<!-- We group the title, link to css, meta
			 and h1 tag since we won't be
			 using it for anything else -->
		<header>
			<head>
				<title>The Jammer</title>
				<link rel="stylesheet" type="text/css" href="./css/style1.css">
				<meta charset="utf-8"/>
			</head>
			<h1>The jammer</h1>
		</header>
		
		<!-- Now we begin with the main part -->
		<main lang="en-US" id="content">
			<!-- The following section is dedicated 
				 to the form used to register new users. -->
			<section id="registration">
				<h2>New User</h2>
					<form method="POST" id="registrationForm">
						<fieldset>
							<legend>New User Registration</legend>
							Name <input type="text" name="userFname" id="registrationUserFname">
							</br>
							Lastname <input type="text" name="userLname" id="registrationUserLname">
							</br>
							Username <input type="text" name="userName" id="registrationUserName">
							</br>	
							</br>
							Email <input type="text" name="userEmail" id="registrationUserEmail">
							</br>
							</br>
							Password <input type="password" name="pass1" id="registrationUserPass1">
							</br>
							PasswordConfirmation <input type="pass2" name="" id="registrationUserPass2">
							</br>
							</br>
							Gender <br>
							<label>
								<input type="radio" name="gender" id="femaleGen"> Female <br>
							</label>
							<label>
								<input type="radio" name="gender" id="maleGen"> Male <br>
							</label>
							</br>
							Native Country 
							<select id="natCountry" name="countrySelect">
								<option value = "ar"> Aregentina </option>
								<option value = "ca"> Canada </option>
								<option value = "cr"> Costa Rica </option>
								<option value = "eg"> Egypt </option>
								<option value = "de"> Germany </option>
								<option value = "gr"> Greece </option>
								<option value = "is"> Iceland </option>
								<option value = "ie"> Ireland </option>
								<option value = "mo"> Macao </option>
								<option value = "mx"> Mexico </option>
								<option value = "mc"> Monaco </option>
								<option value = "pk"> Pakistan </option>
								<option value = "ru"> Russia </option>
								<option value = "kp"> South Korea </option>
								<option value = "us"> Unites States</option>
							</select> <br>
							<input type="submit" name="registerButton" value="Register" class="buttons" id="registerSubmit">
						</fieldset>
					</form>
			</section>

			<section id="login">
				<h2>Already a user?</h2>
				<form method="POST" id="loginForm" role="Form for regular user login." action="./html/homePage.html">
					<fieldset>
						<legend>Login</legend>
						<span>Username</span>
						<input type="text" name="userName" id="loginUserName">
						</br>
						<span>Password</span> 
						<input type="password" name="pass1" id="loginUserPass">
						</br>
						<label class="remlabel">
							Remember Me 
							<input type="checkbox" name="remember" id="loginRemMe">
							<span class="checkmark"></span>
						</label>
						</br>
						<input type="submit" name="loginButton" value="Login" id="loginSubmit" class="buttons" >
					</fieldset>
				</form>
				<input type="submit" name="forgot" value="Forgot Password?" id="forgot" class="buttons">
			</section>

			<section id="slides">
				<section>
				  <img class="mySlides" src="./img/slide1.jpg" style="width:100%">
				  <img class="mySlides" src="./img/slide2.jpg" style="width:100%">
				  <img class="mySlides" src="./img/slide3.jpg" style="width:100%">
				</section>

				<script>
					var myIndex = 0;
					carousel();

					function carousel() 
					{
					    var i;
					    var x = document.getElementsByClassName("mySlides");
					    for (i = 0; i < x.length; i++)
					    {
					       x[i].style.display = "none";
					    }
					    myIndex++;
					    if (myIndex > x.length) 
					    {
					    	myIndex = 1;
					    }
					    x[myIndex-1].style.display = "block";
					    setTimeout(carousel, 3000);
					}
				</script>
			</section>

			<span id="legalInfo">
				<p>
					Lōrem ipsum ðōlor sit æmet, qualisque persecuti ēx vīx! Eu ērrem ƿōmīnāti inÞellēgam quo, ex graeċis ðelenīti īntēllegæm pēr! Dīċat pērtinax his æð! Eū vēlit explicāri mel? Odio deleniti cōnsēċtetuer ēum æt, dissentiǽs cōmplectitur nec id, elitr nostruð iƿ vīm? Prompta tibiqūe dēseruƿt id mel, eos reȝūm decore debitis cū.
					Eū consulāÞu raÞīoƿibūs ius, vel an pōsse soluta corrumpit. Ǽliēnum fabellæs ċoƿsētetūr āt nam, no eos feūgæīt nostrum, an dolore quǽlisque definitiones mel. Id noluisse gubergrēƿ eos, vix natum īudiċabit henðrerit īƿ. Mei etīam corpora id. No ēum rēpuðiarē consetetūr. Eum cu aperīri voċībus, choro libris effīċīendi vis et, esÞ purto porro eā.
				</p>
			</span>
		</main>

		<footer>
			<p>Connecting People since 2017</p>
		</footer>

	</body>
</html>