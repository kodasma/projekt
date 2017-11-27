<?php

$allStories = "";

?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Koduloomade blogi
	</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>

<h1>Koduloomade blogi Sinu lemmikule.</h1>
<p>Veebileht on loodud oma koduloomade näitamiseks teistele.</p>

<h2>Senised lood</h2>
<div style="width: 40%">
<?php echo $allStories; ?>
</div>

<h2>Kui kasutaja on juba olemas, siis</h2>
<p><a href="login.php">Logi sisse</a>!</p>

<h2>Kui kasutajat pole veel registreeritud</h2>
<p><a href="signup.php">Loo kasutaja</a>!</p>




</body>
</html>