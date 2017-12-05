<?php

  // require("../../../config.php");
  require("functions.php");

  //kui on sisseloginud, siis kohe upload lehele
  if (isset($_SESSION["userId"])) {
    header("Location: upload.php");
    exit();
  }

  $loginEmail = "";
  $loginEmailError = "";
  $notice = "";

  //kas logitakse sisse
  if (isset($_POST["loginButton"])) {
     //kas on kasutajanimi sisestatud
    if (isset ($_POST["loginEmail"])){
      if (empty ($_POST["loginEmail"])){
        $loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
      } else {
        $loginEmail = $_POST["loginEmail"];
      }
    }
    if(!empty($loginEmail) and !empty($_POST["loginPassword"])) {
      //kutsun sisselogimise funktsiooni
      $notice = signIn($loginEmail, $_POST["loginPassword"]);
    }
  } //if loginButton
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Sisselogimine</title>
  <link rel="stylesheet" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Telex&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>
	<h1 class="li-header">Logi sisse</h1>
	
	<form class="form li-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Kasutajanimi (E-post): </label><br>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>">
    <span><?php echo $loginEmailError; ?></span>
		<br><br>
		<label>Salasõna: </label><br>
		<input name="loginPassword" placeholder="Salasõna" type="password">
    <span></span>
		<br><br>
		<input name="loginButton" type="submit" value="Logi sisse">
    <span><?php echo $notice; ?></span>
	</form>
  <p class="menu-item menu-item-main"><a href="main.php">Pealeht</a></p>
		
</body>
</html>

  </body>
</html>
