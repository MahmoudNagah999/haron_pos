<?php
ob_start(); // Initiate the output buffer
//ini_set('display_errors', 1);
//error_reporting(~0);
/* check connection */
error_reporting(0);
/* ini_set('display_errors',1);
  ini_set('display_startup_errors',1);
  error_reporting(-1); */
//$activationcode=file_get_contents("activationcode.txt");
$req_uri = $_SERVER['REQUEST_URI'];
$tenantName = explode('/', substr($req_uri, 1, strrpos($req_uri, '/')))[0];
$db_suffix = "etolv_";
$db_suffix = "cairo_";
/*
$tenant_res = $db_suffix . $tenantName;
$databasehost = "localhost";
$databaseuser = $tenant_res;
//$databasepass=null;
$databasepass = $tenant_res;
$databasename = $tenant_res;
*/
$databaseuser="root";
$databasepass="";
$databasename="pos";

if ("localhost:2222" == $_SERVER['HTTP_HOST'] || true) {

    $databaseuser = "root";
    $databasepass = "";
    $databasename = "marchent";
//    $databasename="merchants";
//    $databasename="mtest";

} else {
    $databaseuser = "fly4u_merchants";
    $databasepass = "merchants123456";
    $databasename = "fly4u_merchants";


}
$con = mysqli_connect($databasehost, $databaseuser, $databasepass, $databasename);
$allow_num_users = 1000;
$allow_num_cat = 50;
$allow_num_items = 10000000;
$commission_sale = 0;
$shipping = 1;
######################
$cur_dir = explode('\\', getcwd());
$cur_dir = $cur_dir[count($cur_dir) - 1];
#####################
//$con=mysqli_connect("localhost","posmsyst_farah","eI@;#0o-BGMP","posmsyst_farahtest");
//$con=mysqli_connect("localhost","viallywe_app","Dg9tex[Fiq+q","viallywe_app");
if (!mysqli_set_charset($con, "utf8")) {
    //printf("Error loading character set utf8: %s\n", mysqli_error($con));
} else {
    // printf("Current character set: %s\n", mysqli_character_set_name($con));
}
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$prefix = "cairo";
include dirname(__FILE__) . "/lang_ar.php";
$expire = time() + 60 * 60 * 24 * 30 * 24;
if (isset($_POST['login'])) {
    setcookie("user", "" . $_POST['username'] . "", $expire);
    setcookie("pass", "" . $_POST['password'] . "", $expire);
    if (isset($_GET['fm'])) {
        //    $url = "https" . $_GET['fm'] . "";
        $url = "index.php";
    } else {
        $url = "index.php";
    }
    header("Location: " . $url . "");
}

$usernamek = @$_COOKIE["user"];
$passwordk = @$_COOKIE["pass"];

$logSql = "SELECT * FROM " . $prefix . "_users where username='$usernamek' and password='$passwordk'";
$result_login = @mysqli_query($con, $logSql);
$num = @mysqli_num_rows($result_login);
if ($num > 0) {
    $login = 1;
    while ($row_login = mysqli_fetch_array($result_login)) {
        $user_id = $row_login['id'];
        $user_branch_id = $row_login['branch_id'];
        $user_branch_id_exploded = explode(',',$row_login['branch_id']);
        $user_name = $row_login['name'];
        $user_username = $row_login['username'];
        $user_password = $row_login['password'];
        $user_IsAdmin = $row_login['IsAdmin'];
        $user_sale = $row_login['sale'];
        $user_order_supply = $row_login['user_order_supply'];
        $user_pdf_order_supply = $row_login['user_pdf_order_supply'];
        $user_excel_order_supply = $row_login['user_excel_order_supply'];
        $user_edit_order_supply = $row_login['user_edit_order_supply'];
        $DeleteSalesInv = $row_login['DeleteSalesInv'];
        $DeleteStoresChange = $row_login['DeleteStoresChange'];
        $user_delete_order_supply = $row_login['user_delete_order_supply'];
        $user_order_supply_report = $row_login['user_order_supply_report'];
        $user_stores_change = $row_login['user_stores_change'];
        $user_edit_stores_change = $row_login['user_edit_stores_change'];
        $user_offers = $row_login['user_offers'];
        $user_edit_offers = $row_login['user_edit_offers'];
        $user_buy = $row_login['buy'];
        $user_SoldReturns = $row_login['SoldReturns'];
        $user_purchasesReturns = $row_login['purchasesReturns'];
        $user_DeleteBllsOfSale = $row_login['DeleteBllsOfSale'];
        $user_DeletePurchaseInvoices = $row_login['DeletePurchaseInvoices'];
        $user_ModifyBillsOfSale = $row_login['ModifyBillsOfSale'];
        $user_ModifyBillsBuy = $row_login['ModifyBillsBuy'];
        $user_Revenue = $row_login['Revenue'];
        $user_Expenses = $row_login['Expenses'];
        $user_Customers = $row_login['Customers'];
        $user_Suppliers = $row_login['Suppliers'];
        $user_GeneralSettings = $row_login['GeneralSettings'];
        $user_Groups = $row_login['Groups'];
        $user_Items = $row_login['Items'];
        $user_UsersAndPermissions = $row_login['UsersAndPermissions'];
        $user_ReportsPurchases = $row_login['ReportsPurchases'];
        $user_SalesReports = $row_login['SalesReports'];
        $user_ReportsSuppliers = $row_login['ReportsSuppliers'];
        $user_CustomerReports = $row_login['CustomerReports'];
        $user_InventoryReports = $row_login['InventoryReports'];
        $user_ReportsRevenues = $row_login['ReportsRevenues'];
        $user_ExpenseReports = $row_login['ExpenseReports'];
        $user_ReportsOfPayments = $row_login['ReportsOfPayments'];
        $user_EditPrice = $row_login['EditPrice'];
        $user_user_treasury = $row_login['user_treasury'];
        $user_profit = $row_login['profit'];
        $user_employee = $row_login['employee'];
        $user_add_item = $row_login['add_item'];
        $user_edit_item = $row_login['edit_item'];
        $user_del_item = $row_login['del_item'];
        $user_status = $row_login['status'];
        $user_AllReports = $row_login['AllReports'];
    }
} else {
    $login = 0;
}

if ($login == "0") {
    $url = "login.php";
    if (basename($_SERVER['PHP_SELF']) == $url or $cur_dir == 'backup') {

    } else {
        $fm = basename("https://" . $_SERVER[HTTP_HOST] . "" . $_SERVER[REQUEST_URI] . "");
        $actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//        $url = "login.php?fm=" . str_replace('https', '', $actual_link) . "";
        header("Location: " . $url . "");
    }
}
?>
<?php

$demo = 0;
if (isset($_POST['Editconfig'])) {
    if ($demo == 1) {
        $Edit_report = '<div class="alert alert-warning text-right">
                   "' . $demo_alert . '"
                            </div>';
    } else {
        $CompanyName = Trim(stripslashes($_POST['CompanyName']));
        $Phone = Trim(stripslashes($_POST['Phone']));
        $TimeZone = Trim(stripslashes($_POST['TimeZone']));

        $Currency = Trim(stripslashes($_POST['Currency']));
        $Language = Trim(stripslashes($_POST['Language']));
        $E_mail = Trim(stripslashes($_POST['E_mail']));
        $Website = Trim(stripslashes($_POST['Website']));
        $Address = Trim(stripslashes($_POST['Address']));
        $ReturnPolicy = Trim(stripslashes($_POST['ReturnPolicy']));
        $CustomField1 = Trim(stripslashes($_POST['CustomField1']));
        $CustomField2 = Trim(stripslashes($_POST['CustomField2']));
        $tax = Trim(stripslashes($_POST['tax']));
        $PrintingAftermarket = Trim(stripslashes($_POST['PrintingAftermarket']));
        if (mysqli_query($con, "UPDATE " . $prefix . "_config set CompanyName='" . $CompanyName . "',TimeZone='" . $TimeZone . "',Currency='" . $Currency . "',Language='" . $Language . "',E_mail='" . $E_mail . "',Website='" . $Website . "',Address='" . $Address . "',ReturnPolicy='" . $ReturnPolicy . "',Phone='" . $Phone . "',CustomField1='" . $CustomField1 . "',CustomField2='" . $CustomField2 . "',PrintingAftermarket='" . $PrintingAftermarket . "',tax='" . $tax . "' WHERE id='1'")) {
            $Edit_report = '<div class="alert alert-success text-right">
' . $Data_is_saved_lang . '
</div>';
        }
    }
}
?>
<?php
$result_get = @mysqli_query($con, "SELECT * FROM " . $prefix . "_config where id='1'");
if (@mysqli_num_rows($result_get) > 0) {
    while ($row_get = mysqli_fetch_array($result_get)) {
        $get_db_id = $row_get['id'];
        $get_db_CompanyName = $row_get['CompanyName'];
        $get_db_isLogo = $row_get['isLogo'];
        $get_db_Logo = $row_get['Logo'];
        $get_db_TimeZone = $row_get['TimeZone'];
        $get_db_Currency = $row_get['Currency'];
        $get_db_sales_type = $row_get['sales_type'];
        if ($get_db_Currency == 1) {
            $get_db_Currency = "ريال";
            $db_currency = "1";
        } else if ($get_db_Currency == 2) {
            $get_db_Currency = "جنيه";
            $db_currency = "2";
        } else if ($get_db_Currency == 3) {
            $get_db_Currency = "دينار";
            $db_currency = "3";
        } else if ($get_db_Currency == 4) {
            $get_db_Currency = "دولار";
            $db_currency = "4";
        } else if ($get_db_Currency == 5) {
            $get_db_Currency = "يورو";
            $db_currency = "5";
        } else {

        }
        $get_db_Language = $row_get['Language'];
        $get_db_E_mail = $row_get['E_mail'];
        $get_db_Website = $row_get['Website'];
        $get_db_PrintingAftermarket = $row_get['PrintingAftermarket'];
        $get_db_Address = $row_get['Address'];
        $get_db_ReturnPolicy = $row_get['ReturnPolicy'];
        $get_db_Phone = $row_get['Phone'];
        $get_db_Branch = $row_get['Branch'];
        $get_db_CustomField1 = $row_get['CustomField1'];
        $get_db_CustomField2 = $row_get['CustomField2'];
        $get_db_CustomField3 = $row_get['CustomField3'];
        $get_db_LastInvoiceNo = $row_get['LastreceivingsInvoiceNo'];
        $get_db_LastsaleInvoiceNo = $row_get['LastsaleInvoiceNo'];
        $get_db_receivings_type = $row_get['receivings_type'];
        $db_cat_items_show = $row_get['cat_items_show'];
        $db_tax = $row_get['tax'];
    }
}
date_default_timezone_set('' . $get_db_TimeZone . '');
$dateonly = date("Y-m-d");
$items_per_page = 100;
$Discount_type = 1; // 1 مبلغ  - 2 نسبة
$BARCODE_type = 0; // 1 found  - 0 not found
$showGroups = 1; //1 ظهور / 0 اخ�?اء
if ($showGroups == 0) {
    $db_cat_items_show = 0;
}
$inv_barcode = 0;
$run_barcode = 1;
$Retail_allow = 0;
$Retail_Buying = 0;
//$run_barcode=0;
$Update_SellBuyPrice = 2;   //1 or 2
$key = "4dd0ae2286d87bf4b4f575b5dddb3a18";
$use_colors = 0;
$use_sizes = 0;
function get_settings($id)
{
    global $con;
    $result_settings = @mysqli_query($con, "SELECT * FROM settings where id='$id'");
    $num = @mysqli_num_rows($result_settings);
    if ($num > 0) {
        while ($row_settings = mysqli_fetch_array($result_settings)) {
            return $row_settings['value'];
        }
    }
}

#################

function NumberBreakdown($number, $returnUnsigned = false)
{
    $negative = 1;
    if ($number < 0) {
        $negative = -1;
        $number *= -1;
    }

    if ($returnUnsigned) {
        return array(
            floor($number),
            ($number - floor($number))
        );
    }

    return array(
        floor($number) * $negative,
        ($number - floor($number)) * $negative
    );
}

#############################

function Get_total_items($sizeid, $colorid, $item)
{
    global $con;
    global $prefix;
    if ($sizeid == "0") {
        $result_qty = @mysqli_query($con, "SELECT (Quantity*-1) as Quantitya  FROM " . $prefix . "_sales where color='$colorid' and item='$item' union all select (Quantity) as Quantitya from " . $prefix . "_receivings where color='$colorid' and item='$item' ");
    } else {
        $result_qty = @mysqli_query($con, "SELECT (Quantity*-1) as Quantitya  FROM " . $prefix . "_sales where color='$colorid' and size='$sizeid' and item='$item' union all select (Quantity) as Quantitya from " . $prefix . "_receivings where color='$colorid' and size='$sizeid' and item='$item' ");
    }
    $num_qty = @mysqli_num_rows($result_qty);

    if ($num_qty > 0) {
        while ($row_qty = mysqli_fetch_array($result_qty)) {
            $totalqty += $row_qty[Quantitya];
        }
        return $totalqty;
    }
}

////////////////////////
function GetQuantity($id, $all = null, $store_id = 0, $date_from = null, $date_to = null)
{
    global $con;
    global $prefix;
############################
    $sqlConStoreReceiv = '';
    $sqlConStoreSale = '';

    if ($date_from != null and $date_to != null) {
        $date_from = str_replace("/", "-", $_GET['date_from']);
        $date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
        $date_to = str_replace("/", "-", $_GET['date_to']);
        $date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
        $date_from = $date_from . " 00:00:00";
//        $date_to =$date_to . " 00:00:00";
        $sqlConStoreReceiv .= ' and  ' . $prefix . '_receivings_inv.date BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
        $sqlConStoreSale .= ' and  ' . $prefix . '_sales_inv.date BETWEEN "' . $date_from . '" AND "' . $date_to . '"';
    }
    if ($store_id > 0) {
        $sqlConStoreReceiv .= " and " . $prefix . "_receivings_inv.store_id = $store_id  ";
        $sqlConStoreSale .= " and " . $prefix . "_sales_inv.store_id = $store_id  ";
    }
    $sqlalast = "SELECT " . $prefix . "_offers_inv.id," . $prefix . "_offers.inv_id," . $prefix . "_offers.Quantity  FROM " . $prefix . "_offers JOIN " . $prefix . "_offers_inv on " . $prefix . "_offers.inv_id = " . $prefix . "_offers_inv.inv_id where item='$id' ";
    $resultalast = @mysqli_query($con, $sqlalast);
    $inv = array();
    $quantity = array();
    $offer_ids = array();
    while ($rowalast = @mysqli_fetch_array($resultalast)) {
        $inv[] = $rowalast['inv_id'];
        $offer_ids[] = $rowalast['id'];
        $quantity[$rowalast['id']] = $rowalast['Quantity'];
    }
    if (count($offer_ids) > 0) {
        $sqlalast = "SELECT DISTINCT(" . $prefix . "_sales.id)," . $prefix . "_sales.item," . $prefix . "_sales.id," . $prefix . "_sales.Quantity*-1 as Quantity," . $prefix . "_sales.date," . $prefix . "_sales.SupplierID FROM " . $prefix . "_sales  JOIN " . $prefix . "_sales_inv on " . $prefix . "_sales.inv_id = " . $prefix . "_sales_inv.inv_id  where " . $prefix . "_sales.item IN(" . implode(',', $offer_ids) . ") and " . $prefix . "_sales.item_status='offers' $sqlConStoreSale";
        $resultalast = @mysqli_query($con, $sqlalast);
        while ($rowalast = @mysqli_fetch_array($resultalast)) {
            $Quantitytotallast += $quantity[$rowalast['item']] * $rowalast['Quantity'];
        }
    }
    $sqlalast = "SELECT DISTINCT(" . $prefix . "_receivings.id)," . $prefix . "_receivings.item," . $prefix . "_receivings.id," . $prefix . "_receivings.Quantity," . $prefix . "_receivings.date," . $prefix . "_receivings.SupplierID FROM " . $prefix . "_receivings  JOIN " . $prefix . "_receivings_inv on " . $prefix . "_receivings.inv_id = " . $prefix . "_receivings_inv.inv_id where " . $prefix . "_receivings.item='$id'  $sqlConStoreReceiv";

    $resultalast = @mysqli_query($con, $sqlalast);
    while ($rowalast = @mysqli_fetch_array($resultalast)) {
        $Quantitytotallast += $rowalast['Quantity'];
    }
    $sqlalast = "SELECT " . $prefix . "_sales.item," . $prefix . "_sales.id," . $prefix . "_sales.Quantity," . $prefix . "_sales.date," . $prefix . "_sales.SupplierID FROM " . $prefix . "_sales  JOIN " . $prefix . "_sales_inv on " . $prefix . "_sales.inv_id = " . $prefix . "_sales_inv.inv_id where " . $prefix . "_sales.item='$id' and " . $prefix . "_sales.item_status!='offers' $sqlConStoreSale";
    $resultalast = @mysqli_query($con, $sqlalast);
    while ($rowalast = @mysqli_fetch_array($resultalast)) {
        $Quantitytotallast -= $rowalast['Quantity'];
    }
    $sqlConStoreStoreChanges = '';
//    if ($date_from==null and $date_to!=null){
//        $date_from=date("d/m/Y") ;
//    }
//    if ($date_from!=null and $date_to==null){
//        $date_to=date("d/m/Y") ;
//    }
    if ($date_from != null and $date_to != null) {
        $date_from = str_replace("/", "-", $_GET['date_from']);
        $date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
        $date_to = str_replace("/", "-", $_GET['date_to']);
        $date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
        $sqlConStoreStoreChanges .= ' and  ' . $prefix . '_stores_change_inv.date BETWEEN "' . $date_from . '" AND "' . $date_to . '" ';
    }

    $sqlConStoreStoreChangesFrom = "";
    $sqlConStoreStoreChangesTo = "";
    if ($store_id > 0) {

        $sqlConStoreStoreChangesFrom .= " and " . $prefix . "_stores_change_inv.store_from_id = $store_id";
        $sqlConStoreStoreChangesTo .= " and " . $prefix . "_stores_change_inv.store_to_id = $store_id";
    }

    $sqlalast = "SELECT " . $prefix . "_stores_change.Quantity FROM " . $prefix . "_stores_change  JOIN " . $prefix . "_stores_change_inv on " . $prefix . "_stores_change.inv_id = " . $prefix . "_stores_change_inv.inv_id where " . $prefix . "_stores_change.item='$id' $sqlConStoreStoreChangesTo $sqlConStoreStoreChanges";

    $resultalast = @mysqli_query($con, $sqlalast);
    while ($rowalast = @mysqli_fetch_array($resultalast)) {
        $Quantitytotallast += $rowalast['Quantity'];
    }

    $sqlalast1 = "SELECT " . $prefix . "_stores_change.Quantity FROM " . $prefix . "_stores_change  JOIN " . $prefix . "_stores_change_inv on " . $prefix . "_stores_change.inv_id = " . $prefix . "_stores_change_inv.inv_id where " . $prefix . "_stores_change.item='$id' $sqlConStoreStoreChangesFrom $sqlConStoreStoreChanges";
    $resultalast1 = @mysqli_query($con, $sqlalast1);
    while ($rowalast1 = @mysqli_fetch_array($resultalast1)) {
        $Quantitytotallast -= $rowalast1['Quantity'];
    }

####################
    if ($all == '1') {


        $getQuantity = get_sum_product_store_data($id, $store_id, $date_from, $date_to)[Quantity];
        return $Quantitytotala = $Quantitytotallast + $getQuantity;
    } else {
        return $Quantitytotala = $Quantitytotallast;
    }
}

#############

function Get_model_name($modelid , $offer = false)
{
    global $con;
    global $prefix;
    if ($offer == "offers"){
        $result_models = @mysqli_query($con, "SELECT * FROM " . $prefix . "_offers_inv where id=" . $modelid . "");
    }else{
        $result_models = @mysqli_query($con, "SELECT item FROM items where id=" . $modelid . " order by id ASC");
    }
    $num_models = @mysqli_num_rows($result_models);
    if ($num_models > 0) {
        while ($row_models = mysqli_fetch_array($result_models)) {

            if ($offer == "offers"){
                $model_db = $row_models['name'];
            }else{
                $model_db = $row_models['item'];
            }
        }
    }
    return $model_db;
}

#######################
function get_user_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_users where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
        }
    }
    return $data;
}

function colors_option($id)
{
    global $con;
    $result_colors = @mysqli_query($con, "SELECT * FROM colors order by id ASC");
    $num_colors = @mysqli_num_rows($result_colors);
    if ($num_colors > 0) {
        while ($row_colors = mysqli_fetch_array($result_colors)) {
            if ($id == $row_colors['id']) {
                $colors_option .= '<option value="' . $row_colors['id'] . '" selected>' . $row_colors['color'] . '</option >';
            } else {
                $colors_option .= '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
            }
        }
        echo $colors_option;
    }
}

function code_option($code)
{
    global $con;
    $result_code = @mysqli_query($con, "SELECT * FROM items");
    $num = @mysqli_num_rows($result_code);
    if ($num > 0) {
        while ($row_code = mysqli_fetch_array($result_code)) {
            if ($code == $row_code['id']) {
                $costs_types .= '<option value="' . $row_code['id'] . '" selected>' . $row_code['item'] . '</option >';
            } else {
                $costs_types .= '<option value="' . $row_code['id'] . '">' . $row_code['item'] . '</option >';
            }
        }
        echo $costs_types;
    }
}

function products_option($id = null)
{
    global $con;
    $result_product = @mysqli_query($con, "SELECT * FROM products where id!=-1");
    $num_product = @mysqli_num_rows($result_product);
    if ($num_product > 0) {
        while ($row_product = mysqli_fetch_array($result_product)) {
            if ($id == $row_product['id']) {
                $products_option .= '<option value="' . $row_product['id'] . '" selected>' . $row_product['product_name'] . '</option >';
            } else {
                $products_option .= '<option value="' . $row_product['id'] . '">' . $row_product['product_name'] . '</option >';
            }
        }
        echo $products_option;
    }
}

#######################

function Get_product_name($productid = null)
{
    global $con;
    $result_products = @mysqli_query($con, "SELECT product_name FROM products where id=" . $productid . " order by id ASC");
    $num_products = @mysqli_num_rows($result_products);
    if ($num_products > 0) {
        while ($row_products = mysqli_fetch_array($result_products)) {
            $product_db = $row_products['product_name'];
        }
    }
    return $product_db;
}

#######################
#########################

function get_color_name($colorid)
{
    global $con;
    $result_colors = @mysqli_query($con, "SELECT * FROM colors where id=" . $colorid . " order by id ASC");
    $num_colors = @mysqli_num_rows($result_colors);
    if ($num_colors > 0) {
        while ($row_colors = mysqli_fetch_array($result_colors)) {
            $color_db = $row_colors['color'];
        }
    }
    return $color_db;
}

#######################

function Get_size_name($sizeid)
{
    global $con;
    $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id=" . $sizeid . " order by id ASC");
    $num_sizes = @mysqli_num_rows($result_sizes);
    if ($num_sizes > 0) {
        while ($row_sizes = mysqli_fetch_array($result_sizes)) {
            $size_db = $row_sizes['size'];
        }
    }
    if ($size_db == null) {
        return 0;
    } else {
        return $size_db;
    }
}

################################# 

function new_bug($bug_num, $date, $notes)
{
    global $con;
    $sqlbug = "INSERT INTO bugs (bug_num, date, notes)
VALUES ('" . $bug_num . "','" . $date . "','" . $notes . "')";
    mysqli_query($con, $sqlbug);
}

#########################
#############################
#############################

function get_clolors_of_item($itemid)
{
    global $con;
    $result = @mysqli_query($con, "SELECT colors FROM items where id=" . $itemid . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $colors = $row['colors'];
        }
    }
    return $colors;
}

#############################

function get_sizes_of_item($itemid)
{
    global $con;
    $result = @mysqli_query($con, "SELECT sizes FROM items where id=" . $itemid . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $sizes = $row['sizes'];
        }
    }
    return $sizes;
}

#######################

function get_price_of_item($itemid)
{
    global $con;
    $result = @mysqli_query($con, "SELECT Retail_price FROM items where id=" . $itemid . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $price = $row['Retail_price'];
        }
    }
    return $price;
}

#######################

function Get_model_barcode($modelid)
{
    global $con;
    $result_models = @mysqli_query($con, "SELECT Barcode FROM items where id=" . $modelid . " order by id ASC");
    $num_models = @mysqli_num_rows($result_models);
    if ($num_models > 0) {
        while ($row_models = mysqli_fetch_array($result_models)) {
            $model_db = $row_models['Barcode'];
        }
    }
    return $model_db;
}

##################################

function Get_model_groupid($modelid)
{
    global $con;
    $result_models = @mysqli_query($con, "SELECT groupid FROM items where id=" . $modelid . " order by id ASC");
    $num_models = @mysqli_num_rows($result_models);
    if ($num_models > 0) {
        while ($row_models = mysqli_fetch_array($result_models)) {
            $model_db = $row_models['groupid'];
        }
    }
    return $model_db;
}

##################################
//$css_dir="http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//$css_dir=dirname($css_dir);

function get_hide_items()
{
    global $con;
    global $prefix;
    $result_hide_items = @mysqli_query($con, "SELECT * FROM " . $prefix . "_items_hide");
    $num_hide_items = @mysqli_num_rows($result_hide_items);
    if ($num_hide_items > 0) {
        while ($row_hide_items = mysqli_fetch_array($result_hide_items)) {
            $hide_items_db .= "'";
            $hide_items_db .= $row_hide_items['item'];
            $hide_items_db .= "'";
            $hide_items_db .= ',';
        }
    }
    if ($num_hide_items < 1) {
        return '0';
    } else {
        return rtrim($hide_items_db, ",");
    }
}

##################

function currently_users()
{
    global $con;
    global $prefix;
    $currently_users = @mysqli_query($con, "SELECT id FROM " . $prefix . "_users");
    return $num_currently_users = @mysqli_num_rows($currently_users);
}

function currently_products()
{
    global $con;
    $currently_products = @mysqli_query($con, "SELECT id FROM products");
    return $num_curr_products = @mysqli_num_rows($currently_products);
}

function currently_items()
{
    global $con;
    $currently_items = @mysqli_query($con, "SELECT id FROM items");
    return $num_curr_items = @mysqli_num_rows($currently_items);
}

function GetVolumeLabel($drive = NULL)
{
    if ($drive == null) {
        $drive = $_SERVER['DOCUMENT_ROOT'][0];
    }
    if (preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir ' . $drive . ':'), $m)) {
        $volname = $m[1];
    } else {
        $volname = '';
    }
    return $volname;
}

###################################################

function get_staff_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_staff where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[commission] = $row['commission'];
        }
    }
    return $data;
}

function get_order_supply_status_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}

function get_region_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_region where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}
function get_centers_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_centers where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}

function get_child_recursive($parent_id, $array)
{

    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_region where parent_id=" . $parent_id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $array[] = $row['id'];
            $array = get_child_recursive($row['id'], $array);

        }
    }
    return $array;
}

function get_region_childs($id)
{
    global $con;
    global $prefix;
    $childs = array();
    $childs [] = $id;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_region where parent_id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $childs [] = $row['id'];
            $childs = get_child_recursive($row['id'], $childs);

        }
    }
    return $childs;
}

function current_order_supply_temp_data($user_id)
{
    global $con;
    global $prefix;
    $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' ");
    $num = @mysqli_num_rows($result_up);

    return $num;
}

function current_order_supply_items_data($inv_id)
{
    global $con;
    global $prefix;
    $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply where inv_id='$inv_id' ");
    $num = @mysqli_num_rows($result_up);
    return $num;
}

function get__order_supply_status_data_by_name($name)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status where name='" . $name . "'");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}

function get_branch_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_branch where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
            $data[logo] = $row['logo'];
        }
    } else {
        $data[name] = '-';
    }
    return $data;
}

function get_product_store_data($item, $store_id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_product_store where item=" . $item . " and store_id=" . $store_id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[Quantity] = $row['Quantity'];
        }
    }
    return $data;
}

function get_sum_product_store_data($item, $store_id = null, $date_from = null, $date_to = null)
{

    $data[Quantity] = 0;
    global $con;
    global $prefix;
    $sqlCon = '';
    if ($store_id > 0) {
        $sqlCon .= ' and store_id=' . $store_id . ' ';
    }
//    if ($date_from==null and $date_to!=null){
//        $date_from=date("d/m/Y") ;
//    }
//    if ($date_from!=null and $date_to==null){
//        $date_to=date("d/m/Y") ;
//    }
    if ($date_from != null and $date_to != null) {
        $date_from = str_replace("/", "-", $_GET['date_from']);
        $date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
        $date_to = str_replace("/", "-", $_GET['date_to']);
        $date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
        $sqlCon .= ' and date BETWEEN "' . $date_from . '" AND "' . $date_to . '"';
    }
    $sql = "SELECT SUM(Quantity) as Quantity  FROM " . $prefix . "_product_store where item=" . $item . " $sqlCon ";
    $result = @mysqli_query($con, $sql);
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[Quantity] = $row['Quantity'];
        }
    }
    return $data;
}

function get_store_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_store where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}

function get_safe_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_safe where id=" . $id . "");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[name] = $row['name'];
            $data[notes] = $row['notes'];
        }
    }
    return $data;
}

function get_treasury_data($ids, $safe_id)
{
    $sqlCon = '';
    if ($ids != NULL) {
        $sqlCon = ' id IN (' . $ids . ')  and ';
    }
    if ($safe_id != NULL) {
        $sqlCon = ' safe_id =' . $safe_id . '  and ';
    }

    global $con;
    global $prefix;
    $sqll = "SELECT * FROM " . $prefix . "_treasury where $sqlCon  id!= ''";
    $result = @mysqli_query($con, $sqll);
    $num = @mysqli_num_rows($result);
    if ($num > 0) {

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $data[$i][id] = $row['id'];
            $data[$i][name] = $row['name'];
            $data[$i][type] = $row['type'];
            $data[$i][safe_id] = $row['safe_id'];
            $data[$i][Amount] = $row['Amount'];
            $data[$i][date] = $row['date'];
            $data[$i][notes] = $row['notes'];

            $i++;
        }
    }
    return $data;
}

###################################################
function get_lastbarcode_of_item()
{
    global $con;
    $result = @mysqli_query($con, "SELECT Barcode FROM items order by Barcode+0 DESC limit 0,1");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $Barcode = $row['Barcode'];
        }
    }
    return $Barcode + 1;
}

###################################################
function get_inv_data($id, $type)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_sales_inv where  inv_id='$id'  and type='$type' and inv_id!=''");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[branch_id] = $row['branch_id'];
            $data[safe_id] = $row['safe_id'];
            $data[store_id] = $row['store_id'];
            $data[inv_id] = $row['inv_id'];
            $data[date] = $row['date'];
            $data[discount] = $row['discount'];
            $data[Total] = $row['Total'];
            $data[supplier] = $row['supplier'];
            $data[PaymentMethod] = $row['PaymentMethod'];
            $data[paid] = $row['paid'];
            $data[DueDate] = $row['DueDate'];
            $data[CheckNumber] = $row['CheckNumber'];
            $data[notes] = $row['notes'];
            $data[type] = $row['type'];
            $data[sales_type] = $row['sales_type'];
            $data[tax] = $row['tax'];
            $data[doc] = $row['doc'];
            $data[staff] = $row['staff'];
            $data[shipping] = $row['shipping'];
        }
        return $data;
    }
}

function get_stores_change_inv_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_stores_change_inv where  inv_id='$id'   and inv_id!=''");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[inv_id] = $row['inv_id'];
            $data[date] = $row['date'];
            $data[id] = $row['id'];
            $data[notes] = $row['notes'];
            $data[store_from_id] = $row['store_from_id'];
            $data[store_to_id] = $row['store_to_id'];
        }
        return $data;
    }
}

function get_offers_data($id)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_offers_inv where  inv_id='$id'   and inv_id!=''");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[inv_id] = $row['inv_id'];
            $data[date] = $row['date'];
            $data[Total] = $row['Total'];
            $data[name] = $row['name'];
        }
        return $data;
    }
}


function get_order_supply_data($id, $type)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_inv where  inv_id='$id'  and type='$type' and inv_id!=''");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[branch_id] = $row['branch_id'];
            $data[inv_id] = $row['inv_id'];
            $data[client] = $row['client'];
            $data[address] = $row['address'];
            $data[mobile1] = $row['mobile1'];
            $data[mobile2] = $row['mobile2'];
            $data[region_id] = $row['region_id'];
            $data[alpha] = $row['alpha'];
            $data[date] = $row['date'];
            $data[discount] = $row['discount'];
            $data[Total] = $row['Total'];
            $data[supplier] = $row['supplier'];
            $data[PaymentMethod] = $row['PaymentMethod'];
            $data[paid] = $row['paid'];
            $data[DueDate] = $row['DueDate'];
            $data[CheckNumber] = $row['CheckNumber'];
            $data[notes] = $row['notes'];
            $data[type] = $row['type'];
            $data[sales_type] = $row['sales_type'];
            $data[tax] = $row['tax'];
            $data[doc] = $row['doc'];
            $data[staff] = $row['staff'];
            $data[shipping] = $row['shipping'];
        }
        return $data;
    }
}

function get_order_supply_inv_data_by_id
($ids, $from = null, $to = null, $mobile1 = null, $status = null, $inv = null, $region = null, $UerID = null, $mobile2 = null, $branch_id = null)
{
    $sqlCon = '';
    if ($ids != NULL) {
        $sqlCon = ' id IN (' . $ids . ')  and ';
    }


    $dateSqlCon = "";
    if ($from != '' and $to != '') {
        $from = stripslashes(date('Y-m-d', strtotime($from)));
        $to = stripslashes(date('Y-m-d', strtotime($to)));

        $dateSqlCon .= " and left(date,10) BETWEEN '" . $from . "' AND '" . $to . "'";
    } elseif ($from == '' and $to != '') {
        $to = stripslashes(date('Y-m-d', strtotime($to)));

        $dateSqlCon .= " and left(date,10)  <=  '" . $to . "'";

    } elseif ($from != '' and $to == '') {
        $from = stripslashes(date('Y-m-d', strtotime($from)));

        $dateSqlCon .= " and left(date,10)  >=  '" . $from . "'";

    } else {
//        $dateSqlCon .="and left(date,10) BETWEEN '".date("d/m/Y")."' AND '".date("d/m/Y")."'";

    }

    $mobile2 = stripslashes($_GET['mobile2']);
    $mobile1 = stripslashes($_GET['mobile1']);
//    echo $status=stripslashes($_GET['status']);
    $inv = stripslashes($_GET['inv']);
//    $branch_id=stripslashes($_GET['branch_id']);
//    die($branch_id);

    $UerID = stripslashes($_GET['UerID']);
    $add_sql = '';
    if ($inv == "" or $inv == null) {
    } else {
        $add_sql .= "inv_id='$inv' and ";
    }
    if ($branch_id == "" or $branch_id == null) {
    } else {
        $add_sql .= "branch_id IN ($branch_id) and ";
    }
    if ($_GET['region_id'] != "null" and $_GET['region_id'] != null and $_GET['region_id'] != '') {
//        $regions=explode(',',stripslashes($_GET['region_id']));

        $i = 0;
        foreach ($_GET['region_id'] as $region) {
            if ($region == "" or $region == null) {
            } else {
                $region_childs = get_region_childs($region);
                $region_childs = implode(',', $region_childs);
                if ($i == 0) {
                    $add_sql .= " ( ";
                    $add_sql .= "    region_id IN ($region_childs )  ";
                } else {
                    $add_sql .= "  or   region_id IN ($region_childs )  ";
                }
            }
            $i++;
        }
        $add_sql .= "   ) and   ";

    }
    if ($UerID == "" or $UerID == null) {
    } else {
        $add_sql_UerID = "user_id='$UerID' and ";
    }
    $add_sql_doc = '';
    if ($mobile1 == "" or $mobile1 == null) {
    } else {
        $add_sql_doc .= " mobile1 like '%$mobile1%' and ";
    }
    if ($mobile2 == "" or $mobile2 == null) {
    } else {
        $add_sql_doc .= " mobile2 like '%$mobile2%' and ";
    }
    if ($status == "" or $status == null) {
    } else {
        $add_sql_doc .= "status IN ($status) and ";
    }

    global $con;
    global $prefix;
    $sql = "SELECT *,left(date,10) as date FROM cairo_order_supply_inv  where  $sqlCon  $add_sql $add_sql_doc inv_id!='' $dateSqlCon order by id asc";
//  die();
    $result = @mysqli_query($con, $sql);
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $data[$i][id] = $row['id'];
            $data[$i][inv_id] = $row['inv_id'];
            $data[$i][branch_id] = $row['branch_id'];
            $data[$i][address] = $row['address'];
            $data[$i][status] = $row['status'];
            $data[$i][notes] = $row['notes'];
            $data[$i][mobile2] = $row['mobile2'];
            $data[$i][mobile1] = $row['mobile1'];
            $data[$i][client] = $row['client'];
            $data[$i][region_id] = $row['region_id'];
            $data[$i][region_name] = get_region_data($row['region_id'])[name];
            $data[$i][branch_name] = get_branch_data($row['branch_id'])[name];
            echo $data[$i][branch_logo] = get_branch_data($row['branch_id'])[logo];
            $data[$i][date] = $row['date'];
            $data[$i][discount] = $row['discount'];
            $data[$i][Total] = $row['Total'];
            $data[$i][supplier] = $row['supplier'];
            $data[$i][PaymentMethod] = $row['PaymentMethod'];
            $data[$i][paid] = $row['paid'];
            $data[$i][DueDate] = $row['DueDate'];
            $data[$i][CheckNumber] = $row['CheckNumber'];
            $data[$i][notes] = $row['notes'];
            $data[$i][type] = $row['type'];
            $data[$i][sales_type] = $row['sales_type'];
            $data[$i][tax] = $row['tax'];
            $data[$i][doc] = $row['doc'];
            $data[$i][staff] = $row['staff'];
            $data[$i][shipping] = $row['shipping'];
            $data[$i][user_id] = get_user_data($row['user_id'])['name'];
            $data[$i][edit_user] = get_user_data($row['edit_user'])['name'];
            $i++;
        }
        return $data;
    }
}

#######################################
function get_stores_change_inv_data_by_id
($ids, $from = null, $to = null, $notes = null, $store_from_id = null, $store_to_id = null)
{
    $sqlCon = '';
    if ($ids != NULL) {
        $sqlCon = ' id IN (' . $ids . ')  and ';
    }


    $add_sql = "";
    $dateSqlCon = "";


    if ($store_from_id == "" or $store_from_id == null) {
    } else {
        $add_sql .= "store_from_id='$store_from_id' and ";
    }
    if ($store_to_id == "" or $store_to_id == null) {
    } else {
        $add_sql .= "store_to_id='$store_to_id' and ";
    }
    if ($notes == "" or $notes == null) {
    } else {
        $add_sql .= "notes like '%$notes%' and ";
    }

    if ($from != '' and $to != '') {
        $from = stripslashes(date('Y-m-d', strtotime($from)));
        $to = stripslashes(date('Y-m-d', strtotime($to)));

        $dateSqlCon .= " and left(date,10) BETWEEN '" . $from . "' AND '" . $to . "'";
    } elseif ($from == '' and $to != '') {
        $to = stripslashes(date('Y-m-d', strtotime($to)));

        $dateSqlCon .= " and left(date,10)  <=  '" . $to . "'";

    } elseif ($from != '' and $to == '') {
        $from = stripslashes(date('Y-m-d', strtotime($from)));

        $dateSqlCon .= " and left(date,10)  >=  '" . $from . "'";

    } else {
//        $dateSqlCon .="and left(date,10) BETWEEN '".date("d/m/Y")."' AND '".date("d/m/Y")."'";

    }
    global $con;
    global $prefix;
    $sql = "SELECT * FROM " . $prefix . "_stores_change_inv where $add_sql  $sqlCon    inv_id!='' $dateSqlCon order by id desc";

    $result = @mysqli_query($con, $sql);
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $data[$i][id] = $row['id'];
            $data[$i][inv_id] = $row['inv_id'];
            $data[$i][date] = $row['date'];
            $data[$i][notes] = $row['notes'];
            $data[$i][store_from_id] = $row['store_from_id'];
            $data[$i][store_to_id] = $row['store_to_id'];
            $i++;
        }
        return $data;
    }
}

#######################################
function get_receivings_inv_data($id, $type)
{
    global $con;
    global $prefix;
    $result = @mysqli_query($con, "SELECT * FROM " . $prefix . "_receivings_inv where  inv_id='$id'  and type='$type' and inv_id!=''");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[vat] = $row['vat'];
            $data[safe_id] = $row['safe_id'];
            $data[store_id] = $row['store_id'];
            $data[inv_id] = $row['inv_id'];
            $data[date] = $row['date'];
            $data[discount] = $row['discount'];
            $data[Total] = $row['Total'];
            $data[supplier] = $row['supplier'];
            $data[PaymentMethod] = $row['PaymentMethod'];
            $data[paid] = $row['paid'];
            $data[DueDate] = $row['DueDate'];
            $data[CheckNumber] = $row['CheckNumber'];
            $data[notes] = $row['notes'];
            $data[type] = $row['type'];
            $data[doc] = $row['doc'];
        }
        return $data;
    }
}

#######################################
function get_client_data($id)
{
    global $con;
    global $prefix;
    $result = mysqli_query($con, "SELECT * FROM " . $prefix . "_clients WHERE id=" . $id . "");
    if (@mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[name] = $row['name'];
            $data[phone] = $row['phone'];
        }
    }
    return $data;
}

function get_supplier_data($id)
{
    global $con;
    global $prefix;
    $result = mysqli_query($con, "SELECT * FROM " . $prefix . "_suppliers WHERE id=" . $id . "");
    if (@mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[name] = $row['name'];
        }
    }
    return $data;
}

function get_expenses_set_data($expenses_id)
{
    global $con;
    global $prefix;
    $sql = "SELECT * FROM " . $prefix . "_expenses_set  WHERE id=(SELECT type FROM " . $prefix . "_expenses  WHERE id=" . $expenses_id . ")";
    $result = mysqli_query($con, $sql);
    if (@mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $data[id] = $row['id'];
            $data[name] = $row['expensestype'];
        }
    }
    return $data;
}

function change_tables_eng()
{
    global $databasename;
    global $con;
    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = '$databasename' 
        AND ENGINE = 'MyISAM'";

    $rs = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($rs)) {
        $tbl = $row[0];
        $data .= $sql = "ALTER TABLE `$tbl` ENGINE = InnoDB; ";
        $data .= "<br />";
        mysqli_query($sql);
    }
    return $data;
}

##########################################
#######################################
$drive = substr(__FILE__, 0, 1);
/*
//if(GetVolumeLabel($drive)=='F677-DCDE'){}else{echo GetVolumeLabel($drive);exit();}
$exp_start=strtotime("2017-05-10");
$exp=strtotime("2017-06-30");
$now=strtotime("now");
if($now>$exp){die();}
if($now<$exp_start){die();}
*/
