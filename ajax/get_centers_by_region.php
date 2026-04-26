<?php
include "../includes/inc.php";

$region_ids = [];

if (isset($_REQUEST['region_ids'])) {
    $region_ids = is_array($_REQUEST['region_ids']) ? $_REQUEST['region_ids'] : [$_REQUEST['region_ids']];
} elseif (isset($_REQUEST['region_id'])) {
    $region_ids = [$_REQUEST['region_id']];
}

$response = '<option value="">المركز</option>';
if(!empty($region_ids)){
    $in = implode(",", array_map('intval', array_filter($region_ids)));
    if ($in != "") {
        $sql = "SELECT id, name FROM " . $prefix . "_centers WHERE parent_id IN ($in) ORDER BY name ASC";
    } else {
        $sql = "SELECT id, name FROM " . $prefix . "_centers ORDER BY name ASC";
    }
    $result = mysqli_query($con, $sql);
    if($result && mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            $response .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
} else {
    // If no region is selected, list all centers
    $sql = "SELECT id, name FROM " . $prefix . "_centers ORDER BY name ASC";
    $result = mysqli_query($con, $sql);
    if($result && mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            $response .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}
echo $response;
?>
