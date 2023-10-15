<?php
include "../includes/inc.php";

$result_gettreasury = mysqli_query($con, "SELECT SUM(Amount) as Amount FROM " . $prefix . "_treasury  where safe_id = " . $_POST['safe_id']);
$row_gettreasury = mysqli_fetch_assoc($result_gettreasury);
echo $totaltreasury = round($row_gettreasury['Amount'], 3);
############################
