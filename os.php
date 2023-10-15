<?php
$os=(PHP_OS);
$hash=Trim(stripslashes($_POST['hash']));
$mc=Trim(stripslashes($_POST['mc']));
/*
up vote 0 down vote
There is 2 different way to check the platform that your php is running on it.
1- using PHP_OS which is a const and will point to the 'operating system name' that your php was built in it.
2- using php built in function php_uname() that will tell you more about platform (Operating system name, Host name, Version information, Release name, Machine type) that your script is running on it.
*/
//Linux
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Turn on output buffering
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');

// Capture the output into a variable
$mycom=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();
$findme = "Physical";
//Search the "Physical" | Find the position of Physical text
$pmac = strpos($mycom, $findme);
// Get Physical Address
if($mc==1){
$mac=substr($mycom,($pmac+36),17);	
	}else{
$mac=md5(substr($mycom,($pmac+36),17));
}
//Display Mac Address
//echo '<h1>'.$mac.'</h1>';
} else if($os=="Linux") {
    function getMacLinux() {
  exec('netstat -ie', $result);
  if(is_array($result)) {
    $iface = array();
    foreach($result as $key => $line) {
      if($key > 0) {
        $tmp = str_replace(" ", "", substr($line, 0, 10));
        if($tmp <> "") {
          $macpos = strpos($line, "HWaddr");
          if($macpos !== false) {
            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos+7, 17)));
          }
        }
      }
    }
    return $iface[0]['mac'];
  } else {
    return "notfound";
  }
}
if($mc==1){$mac=getMacLinux();}else{$mac=md5(getMacLinux());}
}else{$mac="notfound";}
$mac=array($mac);
//echo json_encode($mac);
foreach($mac as $val) {
	if($mc==1){echo"$val";}else{
if($hash=="$val"){
    echo 1;
    exit;
}
	}
	
}
?>