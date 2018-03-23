<?php
session_start();

print_r($_SESSION);

?>

<!DOCTYPE html>
<html>
<head>
	<title>page1</title>
</head>
<body>

	<div ><a href="login.php?action=logout">logout</a></div>

</body>
</html>