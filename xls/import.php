<?php
include dirname(__DIR__)."/includes/inc.php";
error_reporting(0);
?>
    <head>
        <meta charset="UTF-8" />
        <title>import</title>
            <style>
        body { padding: 30px }
        form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px ;width: 400px;}
        .progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; height: 2px;}
        .bar { background-color: #B4F5B4; width:0%; height:2px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; }
        #status{margin-top: 30px;}
    </style>
    </head>
<?php    
if(!empty($_POST)){
#################################
 $filename = $_FILES["file"]["name"];
	$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
	$file_ext = substr($filename, strripos($filename, '.')); // get file name
	$filesize = $_FILES["file"]["size"];
	$allowed_file_types = array('.xlsx','.xls');	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000))
	{	
		// Rename file
		$newfilename = time().$file_ext;
		if (file_exists("upload/" . $newfilename))
		{
			// file already exists error
			echo "You have already uploaded this file.";
		}
		else
		{		
			move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
			echo "File uploaded successfully.";		
		}
	}
	elseif (empty($file_basename))
	{	
		// file selection error
		echo "Please select a file to upload.";
	} 
	elseif ($filesize > 2000000)
	{	
		// file size error
		echo "The file you are trying to upload is too large.";
	}
	else
	{
		// file type error
		echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
		unlink($_FILES["file"]["tmp_name"]);
	}

#################################    
/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');

/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';
$inputFileName = 'upload/'.$newfilename;
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);
$iii=1;
for ($index = 2; $index < count($sheetData)+1; $index++) {
$cl_A=$sheetData[$index]['A'];
$cl_B=$sheetData[$index]['B'];
$cl_C=$sheetData[$index]['C'];
$cl_D=$sheetData[$index]['D'];
$cl_E=$sheetData[$index]['E'];
#################################
$cl_F=$sheetData[$index]['F'];
$cl_G=$sheetData[$index]['G'];
$cl_H=$sheetData[$index]['H'];
$cl_I=$sheetData[$index]['I'];
$cl_J=$sheetData[$index]['J'];
$cl_K=$sheetData[$index]['K'];
$cl_L=$sheetData[$index]['L'];
$cl_M=$sheetData[$index]['M'];
$cl_N=$sheetData[$index]['N'];
$cl_O=$sheetData[$index]['O'];
$cl_P=$sheetData[$index]['P'];
$cl_Q=$sheetData[$index]['Q'];
$cl_R=$sheetData[$index]['R'];
$cl_S=$sheetData[$index]['S'];
$cl_T=$sheetData[$index]['T'];
$cl_U=$sheetData[$index]['U'];
###################
if($cl_A==""){}else{
                    $sql = "INSERT INTO items (item, Quantity, price, Retail_price, groupid, OrderNo)
VALUES ('$cl_A','$cl_B','$cl_C','$cl_D','$cl_E','1')";
                    //echo($sql);
                    mysqli_query($con, $sql);
                    if (mysqli_errno($con)>0) {
                        echo"<br /> ".($iii+1)." _ $cl_A <br />";
                    }else{
                       //   echo"........................Ok <br />";
                    }
}
####################
$iii++;}
}
?>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body>
   <form action="" method="post" id="form" enctype="multipart/form-data">
        <h3>IMPORT</h3>
        <table>
            <tr><td>File:</td><td><input type="file" name="file"></td></tr>
            <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Upload"></td></tr>
        </table>      
    </div>
    </form>
</body>
</html>