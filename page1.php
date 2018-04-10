<?php
session_start();
include_once 'config.php';
print_r($_SESSION);

echo "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . $_SERVER['SERVER_NAME'] . $folder ."/login.php"."\nnnn **";

echo hash_hmac('sha512', 'textsdgfgfdhfhthbgfhgbfghgfhgi2sd', "kssfghfghfhgfhgfhrtyret5y654y7645day");
echo "\n";
$n = strpos("wwoHecccllo wdorld!", "wo");
if ($n >= 0){
    echo $n;
}
$ss = "script type=\"text/javascript\" src=\"../js/form2.js\"";
echo $ss;
//echo $_SERVER['PHP_SELF'];
//d2d7c343df1f9304f968e14f6fa6d82f1f9760681751a865677a9b3e30735c56a2b3128cd19ab48dd6b5704a0dc94d25795420cc3a40995d866791058c1b3b2f

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Random Generator</title>

</head>
<body>
<h1>Hello World</h1>
<p><button>Click here to randomly generate a string</button></p>

<script src="jquery-1.11.2.js"></script>
<script>

$('p').click (function makeid(){
var text = "";
var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

for( var i=0; i < 5; i++ )
text += possible.charAt(Math.floor(Math.random() * possible.length));
return document.write(text);

});

</script>
</body>
</html>


