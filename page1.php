<?php
session_start();

print_r($_SESSION);

echo hash_hmac('sha512', 'textsdgfgfdhfhthbgfhgbfghgfhgi2sd', "kssfghfghfhgfhgfhrtyret5y654y7645day");

//d2d7c343df1f9304f968e14f6fa6d82f1f9760681751a865677a9b3e30735c56a2b3128cd19ab48dd6b5704a0dc94d25795420cc3a40995d866791058c1b3b2f

?>
<!DOCTYPE html>
<html>
<head>
	<title>page1</title>
</head>
<body>

	<div><a href="logout.php">logout</a></div>

</body>
</html>