<?php
include "../includes/inc.php";
$region_ids = isset($_POST['region_ids']) ? $_POST['region_ids'] : [];

$response = '<option value=""></option>';
if(!empty($region_ids) && is_array($region_ids)){
    $in = implode(",", array_map('intval', $region_ids));
    $sql = "SELECT id, name FROM " . $prefix . "_centers WHERE parent_id IN ($in) ORDER BY name ASC";
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
