<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Password</title>
	<link rel="stylesheet" href="css/style.css" media="screen" />
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

    <div id="password-form">
        <h1>Password</h1>

        <fieldset>
            <form method="post" onsubmit = "return validateForm()">
                Password <input type="password" required name="password" id="password">
                Confirm password <input type="password" required name="passwordConfirm" id="passwordConfirm">
				
				<span id="phpManipulation">
				<?php
				// php manipulation
				$infoPost = 'yes';// default: all data is received
				if(!isset($_POST['password'])){$infoPost = 'no';}
				if(!isset($_POST['passwordConfirm'])){$infoPost = 'no';}

				if($infoPost == 'yes'){
					echo'<br><p><font color="green">PHP-manipulation:</font></p>';
					$password = $_POST['password'];
					$passwordConfirm = $_POST['passwordConfirm'];
					// compare passwords
					if($password == $passwordConfirm){echo'<p>Passwords are the same.</p>';}
					else{echo'<p><font color="red">Passwords are not the same.</font></p>';}
					//reliability of password
					$patternPassword = '/(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*]{5,}/';
					if(!preg_match($patternPassword, $password)){echo'<p><font color="red">Weak password.</font></p>';}
					else{echo'<p>Good password.</p>';}
					// echo received data
					echo 'Received data: <br>';
					echo 'field "password" - '.$password.'<br>';
					echo 'field "confirm password" - '.$passwordConfirm.'<br>';
				}
				?>
				</span>
				
				<span id="jsManipulation"></span>
				<span id="passwordNote"></span>
				<span id="passwordConfirmNote"></span>
				
				<span id="jQueryManipulation"></span>
				<span id="reliabilityOfPassword"></span>
				<span id="comparePasswords"></span>

                <input type="submit" value="Go:)">
            </form>
        </fieldset>

    </div>
	
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script>
	var password = document.getElementById('password').value;
	var passwordConfirm = document.getElementById('passwordConfirm').value;
	var patternPassword = /(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*]{5,}/g;
	
	// безопасность пароля
	$('#passwordConfirm').click(function(){
		var password = document.getElementById('password').value;
		var passwordConfirm = document.getElementById('passwordConfirm').value;
		var patternPassword = /(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*]{5,}/g;
	
		document.getElementById('jQueryManipulation').innerHTML = '<br><p><font color="blue">jQuery-manipulation</font></p>';
		document.getElementById('phpManipulation').innerHTML = '';
		
		if(!patternPassword.test(password)){
			document.getElementById('reliabilityOfPassword').innerHTML = '<p><font color="red">пароль должен состоять минимум из 5 символов, при этом в пароле должны быть как минимум одна цифра и буква (буквы только латинские) </font></p>';
		}
		else{document.getElementById('reliabilityOfPassword').innerHTML = '<p>good password</p>';}
	});
	
	// сравнение паролей
	$('#passwordConfirm').keyup(function(){
		var password = document.getElementById('password').value;
		var passwordConfirm = document.getElementById('passwordConfirm').value;
		var patternPassword = /(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*]{5,}/g;
	
		if(password == passwordConfirm){document.getElementById('comparePasswords').innerHTML = '<p>passwords are the same</p>';}
		else{document.getElementById('comparePasswords').innerHTML = '<p><font color="red">passwords are not the same</font></p>';}
	});

	// после клика на submit
	function validateForm(){
		var password = document.getElementById('password').value;
		var passwordConfirm = document.getElementById('passwordConfirm').value;
		var patternPassword = /(?=.*[0-9])(?=.*[a-zA-Z])[0-9a-zA-Z!@#$%^&*]{5,}/g;
		
		document.getElementById('jsManipulation').innerHTML = '<br><p><font color="orange">JavaScript-manipulation</font></p>';
		
	// заполненность полей формы (due to "required" {html5} this code can be removed)
		function formFieldOccupancy(variable, variableName){
			var note = variableName+'Note';
			if(variable.length == 0){
				document.getElementById(note).innerHTML = '<p><font color="red">Поле "' + variableName + '" должно быть заполненным</font></p>';
				return false;
			}
			else{document.getElementById(note).innerHTML = '<p>Поле ' + note + ' заполненно</p>';}
		}
		if(formFieldOccupancy(variable = password, variableName = 'password') == false){return false;}
		if(formFieldOccupancy(variable = passwordConfirm, variableName = 'passwordConfirm') == false){return false;}
		// /заполненность полей формы (due to "required" {html5} this code can be removed)
		
		// соответствует ли password требованиям
		if(!patternPassword.test(password)){
			document.getElementById('passwordNote').innerHTML = '<p><font color="red">пароль должен состоять минимум из 5 символов, при этом в пароле должны быть как минимум одна цифра и буква (буквы только латинские) </font></p>';
			return false;
		}
		else{document.getElementById('passwordNote').innerHTML = '<p>good password</p>';}
		
		// идентичны ли пароли
		if(password == passwordConfirm){document.getElementById('passwordConfirmNote').innerHTML = 'passwords are the same';}
		else{
			document.getElementById('passwordConfirmNote').innerHTML = '<p><font color="red">passwords are not the same</font></p>';
			return false;
		}

	}
	
</script>

</body>
</html>