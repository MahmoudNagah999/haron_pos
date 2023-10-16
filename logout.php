<?php
setcookie("user", "", time()-99999999999999);
setcookie("pass", "", time()-99999999999999);
/*	function backURL($url)
	{
		$backURL = split("backURL=",$url);
		return $backURL[1];
	}*/
$fm=urlencode(getenv("HTTP_REFERER"));
$url="login.php?fm=".str_replace('http', '', $fm)."";
header("Location: ".$url."");
exit();
?>