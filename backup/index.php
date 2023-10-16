<?php
include"../includes/inc.php";
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$user_ip = getUserIP();
if ($user_IsAdmin != 1 and $user_ip!=="::1") {
echo"<div class='alert alert-warning text-right'>Not Permission</div>";
die();
} else {
    echo $user_IsAdmin;
}
function EXPORT_TABLES($host,$user,$pass,$name,  $tables=false, $backup_name=false ){
    $time_stamp=time();
	$mysqli = new mysqli($host,$user,$pass,$name); $mysqli->select_db($name); $mysqli->query("SET NAMES 'utf8'");
	$queryTables = $mysqli->query('SHOW TABLES'); while($row = $queryTables->fetch_row()) { $target_tables[] = $row[0]; }	if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
	$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--Database: `".$name."`\r\n\r\n\r\n";
	foreach($target_tables as $table){
		$result	= $mysqli->query('SELECT * FROM '.$table); 	$fields_amount=$result->field_count;  $rows_num=$mysqli->affected_rows; 	$res = $mysqli->query('SHOW CREATE TABLE '.$table);	$TableMLine=$res->fetch_row();
		$content .= "\n\n".$TableMLine[1].";\n\n";
		for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) {
			while($row = $result->fetch_row())	{ //when started (and every after 100 command cycle):
				if ($st_counter%100 == 0 || $st_counter == 0 )	{$content .= "\nINSERT INTO ".$table." VALUES";}
					$content .= "\n(";
					for($j=0; $j<$fields_amount; $j++)  { $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ; }else {$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}		}
					$content .=")";
				//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
				if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) {$content .= ";";} else {$content .= ",";}	$st_counter=$st_counter+1;
			}
		} $content .="\n\n\n";
	}
	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
	$backup_name = $backup_name ? $backup_name : $time_stamp.".sql";
        // echo $content; exit;
	//header('Content-Type: application/octet-stream');	header("Content-Transfer-Encoding: Binary"); header("Content-disposition: attachment; filename=\"".$backup_name."\"");  echo $content; exit;
$myfile = fopen("".$time_stamp.".sql", "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);                          }
EXPORT_TABLES("$databasehost","$databaseuser","$databasepass","$databasename" );
?>
<table class="table-bordered text-center" style="width: 100%;">
        <tr style="background-color: #A7A7A7;">
            <th style="text-align: center;">الوقت</th>
                                    <th style="text-align: center;">التاريخ</th>
                                    <th style="text-align: center;">الملف</th>
                                </tr>
                             <?php
$files1 = scandir(".",1);
$i=0;
foreach ($files1 as $value) {
    if (strpos($value, '.sql') !== false) {
       $split=explode(".sql", $value);
     echo" <tr>
      <td><a href='backup/".$value."' target='_BLANK'>".date('H:i:s', $split[0])."</a></td>
      <td><a href='backup/".$value."' target='_BLANK'>".date('m/d/Y', $split[0])."</a></td>
          <td><a href='backup/".$value."' target='_BLANK'>".$value."</a></td>
       </tr>";
  if($i==31){   break; }
     $i++;
}
   
    
}
?>
                               
                            </table>