<?php
	$allStories = "";
	require("functions.php");
	$allStories = readAllStories();
?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Koduloomade blogi
	</title>
	<link rel="stylesheet" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Telex&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>
<div class="container">
	<div>
		<h1 class="header">Sinu lemmikud</h1>

		<div class="menu">
			<a class="menu-item menu-item-login" href="login.php">Lisa oma lugu</a>
			<a class="menu-item menu-item-about" href="signup.php">Loo kasutaja</a>
		</div>
	</div>

	<div style="width: 40%">
	<?php echo $allStories; ?>
	</div>

</div>
</body>
</html>