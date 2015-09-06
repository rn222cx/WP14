<?php


// hämta person nummer
require_once 'FI.php';

// function till säkerhet
/*function cleanMe($input) {
   $input = mysql_real_escape_string($input);
   $input = htmlspecialchars($input);
   $input = strip_tags($input);
   $input = stripslashes($input);
   return $input;
}*/



if (isset($_POST['submit'])){

	
	$username = htmlspecialchars($_POST["username"]);
	$pin = htmlspecialchars($_POST["personal_number"]);
	$actor = $_POST["actor"];
	// Här kunde hash användas för lösenords säkerhet. Men funkar inte lokalt
	$email = htmlspecialchars($_POST["email"]);
	$password = htmlspecialchars($_POST["password"]);
	$repeatpassword = htmlspecialchars($_POST["repeatpassword"]);
	$club = htmlspecialchars($_POST["club"]);
	
	$errorMessage = "<br>";
	if (strlen($username) < 4 || strlen($username) > 30) {
		$errorMessage = $errorMessage . "Namnet måste vara mellan 4 och 30 tecken långt" . "<br>";
	}

	if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
  		$errorMessage = $errorMessage . "Endast bokstäver och mellanslag är tillåtna i namn" . "<br>";
	}
	
	if(!Pnum::check($pin)) {
		$errorMessage = $errorMessage . "Person nummer är inte giltligt" . "<br>";
	}

    if($actor == '') {
    	$errorMessage = $errorMessage . "Välj en aktör" . "<br>";
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   	$errorMessage = $errorMessage . "Email är inte valid" . "<br>";	
	}
	
	if (strlen($password) <= 8 || strlen($password) >=25) {
		$errorMessage = $errorMessage . "Lösenordet måste vara mellan 8 och 25 tecken långt" . "<br>";
	}
	
	if($repeatpassword != $password){
		$errorMessage = $errorMessage . "Lösenorden är inte identiska" . "<br>";
	}

	// Kolla om fälten är tomma
	$required = array('username', 'personal_number', 'password', 'repeatpassword', 'email', 'club');
	$error = false;
	foreach($required as $field) {
	  if (empty($_POST[$field])) {
	    $error = true;
	  }
	}
	if ($error) {
	  $errorMessage = $errorMessage . "Alla fällt måste fyllas i" . "<br>";
	}

	$succeed = "<font color='Green'>Din registrering skickas till administratören för godkännande</font>";
}
?>

	<html>
	<head>
	<meta charset="UTF-8" />
	<title>Registrera användare</title>
	</head>
	<body>

<h1>Användningsfall registrering</h1>

<form name ="form" method ="post" action ="">

       Fullständigt namn: <br />
       <input type="text" name="username"  value="<?php print $username; ?>" id="username" size="35" /><br />
       Person nummer: (exempel: ÅÅMMDD-YYYY) <br />
       <input type="text" name="personal_number" value="<?php print $pin; ?>" id="personal_number" size="35" /><br />
       Val av aktör: <br />
	      <select name="actor">
	      <option value="" name="actor" selected="">Välj aktör</option>
		    	<option value="Sekreterare" <?php if($actor == "Sekreterare") echo "selected='selected'"; ?>>Sekreterare</option> 
		    	<option value="Lag ledare" <?php if($actor == "Lag ledare") echo "selected='selected'"; ?>>Lag ledare</option>
		   	<option value="annat" <?php if($actor == "annat") echo "selected='selected'"; ?>>annat</option>
	     </select>
    	 <br /><br />
       Email: <br />
       <input type="text" name="email" value="<?php print $email; ?>" id="email" size="35" />
       <br />
       Lösenord: <br />
       <input type="password" name="password" id="password" size="35" />
       <br />
       Upprepa lösenord: <br />
       <input type="password" name="repeatpassword" id="repeatpassword" size="35" />
       <br />			 
       Namn på klubb: <br />
       <input type="text" name="club" value="<?php print $club; ?>" id="club" size="35" />
       <br /><br />

<input type = "submit" name = "submit"  value = "Skicka">
</form>

<?php 
	if($errorMessage == "<br>"){
		echo $succeed;
	}
	else{
   	echo '<div id="error" style="color:red; background-color:yellow;"'.$errorMessage.'</div>';
	}
	$errorMessage == null;
?>
	</body>
	</html>
