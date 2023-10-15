<?php
function GetVolumeLabel($drive=NULL) {
if($drive==null){$drive=$_SERVER['DOCUMENT_ROOT'][0]; }
if (preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
$volname = $m[1];
} else {
$volname = '';
}
return $volname;
}
 echo"100E"; echo GetVolumeLabel($drive=NULL); echo"50V";
?>